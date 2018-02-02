<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%external_platform_feeds}}".
 *
 * @property integer $id
 * @property integer $platform_id
 * @property integer $ad_id
 * @property string $body
 * @property string $params
 * @property integer $status
 *
 * @property Ads $ad
 * @property ExternalPlatforms $platform
 */
class ExternalPlatformFeeds extends \yii\db\ActiveRecord
{

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    /**
     * 
     * @param integer $status
     * @return mixed
     */
    public function getStatusLabels($status = null)
    {
        $ar = [
            self::STATUS_PENDING => 'ОЖИДАНИЕ',
            self::STATUS_APPROVED => 'УТВЕРЖДЕН',
            self::STATUS_REJECTED => 'ОТКЛОНЕН',
        ];
        return $status !== null ? $ar[$status] : $ar;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%external_platform_feeds}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['platform_id', 'ad_id', 'status'], 'integer'],
                [['body', 'params'], 'string'],
                [['ad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::className(), 'targetAttribute' => ['ad_id' => 'id']],
                [['platform_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExternalPlatforms::className(), 'targetAttribute' => ['platform_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'platform_id' => 'Идентификатор платформы',
            'ad_id' => 'Идентификатор объявления',
            'body' => 'Тело фида',
            'params' => 'Параметры',
            'status' => 'Статус',
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
     * @return \yii\db\ActiveQuery
     */
    public function getPlatform()
    {
        return $this->hasOne(ExternalPlatforms::className(), ['id' => 'platform_id']);
    }

}
