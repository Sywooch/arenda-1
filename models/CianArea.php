<?php

namespace app\models;

use yii;
use app\components\extend\ActiveRecord;

class CianArea extends ActiveRecord
{
	public static function tableName()
	{
		return '{{%cian_areas}}';
	}
}
