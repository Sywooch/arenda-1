<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ad_attribute_values}}".
 *
 * @property integer $id
 * @property integer $ad_id
 * @property integer $attribute_id
 * @property string $value
 *
 * @property AdAttributeValues $attribute0
 * @property AdAttributeValues[] $adAttributeValues
 * @property Ads $ad
 */
class AdAttributeValues extends \app\components\extend\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), []);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad_attribute_values}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id', 'attribute_id'], 'integer'],
            [['value'], 'string'],
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
            'attribute_id' => 'Attribute ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeMap()
    {
        return $this->hasOne(AttributesMap::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdAttributeValues()
    {
        return $this->hasMany(AdAttributeValues::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Ads::className(), ['id' => 'ad_id']);
    }

}