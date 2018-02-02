<?php
/**
 * behavior for any model which need to attach files
 * 
 * @author postolachiserghei
 */

namespace app\models\behaviors\common;

use yii;
use yii\db\BaseActiveRecord;
use app\components\helpers\CommonHelper;
use yii\web\UploadedFile;
use app\models\Files;

/**
 * This is the behavior for data attribute in \app\models\LeaseContracts".
 *
 * @property \app\components\extend\ActiveRecord $owner
 */
class SaveFilesBehavior extends \yii\base\Behavior
{
    public $fileAttributes;
    public $saveFileForOwner = true;

    /**
      function(string $fileName,UploadedFile $file){
      .....
      }
     * @var function  
     */
    public $beforeFileSave;

    /**
      function($this $owner,Files $file){
      .....
      }
     * @var function  
     */
    public $afterFileSave;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            BaseActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function beforeValidate()
    {
        foreach ($this->fileAttributes as $attribute) {
            $this->owner->{$attribute} = $this->owner->getRuleParam($attribute, 'file', 'maxFiles', 1) === 1 ?
                    UploadedFile::getInstance($this->owner, $attribute) :
                    UploadedFile::getInstances($this->owner, $attribute);
        }
    }

    public function afterValidate()
    {
        foreach ($this->fileAttributes as $attribute) {
            $this->owner->{$attribute} = $this->owner->isNewRecord ? null : @$this->owner->oldAttributes[$attribute];
        }
    }

    public function beforeSave()
    {
        if ($this->saveFileForOwner) {
            $this->prepareFilesToSave();
        }
    }

    public function afterSave()
    {
        if (!$this->saveFileForOwner) {
            $this->prepareFilesToSave();
        }
    }

    /**
     * prepare files then save them
     */
    public function prepareFilesToSave()
    {
        $path = '/public/uploads/' . date('y/m/d') . '/';
        $attributeValues = [];
        foreach ($this->fileAttributes as $attribute) {
            $saveFileBehavior = $this;
            CommonHelper::file()->save($path, [
                'model' => $this->owner,
                'attribute' => $attribute,
                'beforeSave' => function($fileName, $info) use ($path, &$saveFileBehavior, $attribute) {
                    if ($beforeFileSave = $saveFileBehavior->beforeFileSave) {
                        if (is_callable($beforeFileSave)) {
                            return $beforeFileSave($fileName, $info);
                        }
                    }
                    return true;
                },
                'afterSave' => function($fileName, $info) use ($path, &$saveFileBehavior, $attribute, &$attributeValues) {
                    if ($file = $saveFileBehavior->saveFile($path, $fileName, $info)) {
                        $saveFileBehavior->owner->getFile($attribute)->delete();
                        $attributeValues[$attribute] = $file->id;
                        if ($afterFileSave = $saveFileBehavior->afterFileSave) {
                            if (is_callable($afterFileSave)) {
                                $afterFileSave($saveFileBehavior->owner, $file);
                            }
                        }
                        return true;
                    }
                }
            ]);
        }
        foreach ($attributeValues as $k => $v) {
            $this->owner->{$k} = $v;
        }
    }

    /**
     * 
     * @param string $path
     * @param string $fileName
     * @param null|UploadedFile $info
     * @return Files
     */
    public function saveFile($path, $fileName, $info)
    {
        $file = new Files();
        /* @var $file Files */
        $file->path = $path;
        $file->size = $info->size;
        $file->title = $info->name;
        $file->mime = $info->type;
        $file->id = strstr($fileName, '.', true);
        $file->extension = $info->extension;
        $file->owner = yii::$app->user->isGuest ? 0 : yii::$app->user->id;
        $file->host = CommonHelper::data()->getParam('tld', 'arendatika.loc');
        $file->status = Files::STATUS_ACTIVE;
        $file->scheme = 'http';
        if ($file->validate() && $file->save()) {
            return $file;
        }
        return null;
    }

    /**
     * 
     * @param string $attribute
     * @return Files
     */
    public function getFile($attribute)
    {
        $file = Files::find()->where(['id' => $this->owner->{$attribute}])->one();
        return $file ? $file : new Files();
    }

    /**
     * delete files of the deleted record
     */
    public function afterDelete()
    {
        foreach ($this->fileAttributes as $attribute) {
            $this->getFile($attribute)->delete();
        }
    }

}