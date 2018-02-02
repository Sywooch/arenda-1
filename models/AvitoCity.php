<?php

namespace app\models;

use yii;
use app\components\extend\ActiveRecord;

class AvitoCity extends ActiveRecord
{
	public static function tableName()
	{
		return '{{%avito_cities}}';
	}
}
