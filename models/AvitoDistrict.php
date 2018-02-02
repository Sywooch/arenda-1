<?php

namespace app\models;

use yii;
use app\components\extend\ActiveRecord;

class AvitoDistrict extends ActiveRecord
{
	public static function tableName()
	{
		return '{{%avito_districts}}';
	}
	
	public function getCity()
	{
		return $this->hasOne(AvitoCity::className(), ['avito_id' => 'city_id']);
	}
}
