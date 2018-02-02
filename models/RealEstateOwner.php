<?php

namespace app\models;

use app\components\extend\ActiveRecord;
use Yii;

/**
 * This is the model class for table "ar_real_estate_owner".
 *
 * @property int $id
 * @property int $real_estate_id
 * @property string $fio
 *
 * @property RealEstate $realEstate
 */
class RealEstateOwner extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ar_real_estate_owner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['real_estate_id'], 'required'],
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'real_estate_id' => 'Real Estate ID',
            'fio' => 'ФИО',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRealEstate()
    {
        return $this->hasOne(RealEstate::className(), ['id' => 'real_estate_id']);
    }
}
