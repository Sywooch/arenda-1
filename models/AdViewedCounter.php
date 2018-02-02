<?php

namespace app\models;

use yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%ad_viewed_counter}}".
 *
 * @property integer $ad_id
 * @property integer $date_created
 * @property integer $views
 *
 * @property Ads $ad
 */
class AdViewedCounter extends \app\components\extend\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
                [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => null,
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad_viewed_counter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['ad_id', 'date_created', 'views'], 'integer'],
                [['ad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::className(), 'targetAttribute' => ['ad_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ad_id' => 'Ad ID',
            'date_created' => 'Date Created',
            'views' => 'Views',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Ads::className(), ['id' => 'ad_id']);
    }

    public static function primaryKey()
    {
        return [
            'ad_id',
            'date_created'
        ];
    }

}
