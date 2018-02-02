<?php

namespace app\models;

use yii;
use app\components\helpers\CommonHelper;
use app\components\extend\Html;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property string $id
 * @property string $scheme
 * @property string $host
 * @property string $path
 * @property string $title
 * @property string $extension
 * @property integer $size
 * @property string $mime
 * @property integer $created_at
 * @property integer $status
 * @property integer $owner
 * @property string $url
 */
class Files extends \app\components\extend\ActiveRecord
{
    const DEFAULT_NO_IMAGE = '/public/img/defaults/no-image.png';
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
                [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['id', 'path', 'extension'], 'required'],
                [['host', 'path', 'title'], 'string'],
                [['size', 'created_at', 'status', 'owner'], 'integer'],
                [['id', 'scheme', 'extension', 'mime'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scheme' => 'Scheme',
            'host' => 'Host',
            'path' => 'Path',
            'title' => 'Title',
            'extension' => 'Extension',
            'size' => 'Size',
            'mime' => 'Mime',
            'status' => 'Status',
            'created_at' => 'Created At',
            'owner' => 'Owner',
        ];
    }

    /**
     * 
     * @param boolean $scheme (http:// or https://) default is false
     * @return string
     */
    public function getUrl($scheme = false)
    {
        $path = $this->getPath();
        return ($scheme ? $this->scheme . '://' . $this->host . $path : $path);
    }

    /**
     * 
     * @param boolean $root default false
     * @return string
     */
    public function getPath($root = false)
    {
        $r = CommonHelper::file()->getPath($this->path) . $this->id . '.' . $this->extension;
        if (is_file($r)) {
            return $root ? $r : ($this->path . $this->id . '.' . $this->extension);
        }
        return $root ? CommonHelper::file()->getPath() . self::DEFAULT_NO_IMAGE : self::DEFAULT_NO_IMAGE;
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
     * remove file
     * @return boolean
     */
    public function deleteFile()
    {
        if (trim($this->id) != '') {
            return CommonHelper::file()->rm($this->getUrl());
        }
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * get image url
     * @param array $options
     * @return string
     */
    public function getImageUrl($options = [])
    {
        if (array_key_exists('width', $options) || array_key_exists('height', $options)) {
            $width = (array_key_exists('width', $options) && (int) $options['width'] > 0) ? (int) $options['width'] : 75;
            $height = (array_key_exists('height', $options) && (int) $options['height'] > 0) ? (int) $options['height'] : 50;
            $src = yii\helpers\Url::to(['/site/image', 'd' => base64_encode(base64_encode(Json::encode([
                                            'filePath' => $this->getPath(true),
                                            'width' => $width,
                                            'height' => $height
            ])))]);
        } else {
            $src = $this->getUrl();
        }
        return $src;
    }

    /**
     * 
     * @param type $options
     * @return type
     */
    public function renderImage($options = [])
    {
        $src = $this->getImageUrl($options);
        $data = [
            'id' => $this->primaryKey
        ];
        if (!array_key_exists('title', $options)) {
            $options['title'] = $this->title;
        }
        if (!array_key_exists('alt', $options)) {
            $options['alt'] = $this->title;
        }
        array_key_exists('data', $options) ? array_merge($options['data'], $data) : $options['data'] = $data;
        return Html::img($src, $options);
    }

    /**
     * get available extensions for image type
     * @param boolean $asString default false
     * @return mixed
     */
    public static function imageExtension($asString = false)
    {
        $ext = [
            'png', 'jpg', 'jpeg', 'gif'
        ];
        return $asString ? implode(',', $ext) : $ext;
    }

    /**
     * max size for image type
     * @param integer $maxMB
     * @return integer
     */
    public static function imageMaxSize($maxMB = 6)
    {
        return (1024 * 1024 * (int) $maxMB);
    }

}
