<?php

namespace app\models;

use yii;
use app\components\extend\ActiveRecord;

class CianMetro extends ActiveRecord
{
	public static function tableName()
	{
		return '{{%cian_metro}}';
	}
	
	public function getArea()
	{
		return $this->hasOne(CianArea::className(), ['cian_id' => 'region_id']);
	}
}
