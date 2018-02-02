<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ad_images}}".
 *
 * @property integer $id
 * @property integer $ad_id
 * @property string $image
 *
 * @property Ads $ad
 */
class AdImages extends \app\components\extend\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['ad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::className(), 'targetAttribute' => ['ad_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ad_id' => 'Ad ID',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Ads::className(), ['id' => 'ad_id']);
    }

    /**
     * get file model 
     * @return Files
     */
    public function getFile()
    {
        $model = $this->hasOne(Files::className(), ['id' => 'image'])->one();
        return $model ? $model : new Files();
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $ad = parent::afterDelete();
        $this->deleteFile();
        return $ad;
    }

    /**
     * delete file
     * @return boolean
     */
    public function deleteFile()
    {
        if ($file = $this->getFile()) {
            return $file->delete();
        }
        return null;
    }

}