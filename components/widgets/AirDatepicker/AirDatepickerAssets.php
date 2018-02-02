<?php

namespace app\components\widgets\AirDatepicker;

use yii\web\AssetBundle;

class AirDatepickerAssets extends AssetBundle
{
	public $sourcePath = '@bower/air-datepicker';

	public $css = [
		'dist/css/datepicker.css',
	];

	public $js = [
		'dist/js/datepicker.js',
	];

	public $depends = [
		'yii\web\JqueryAsset',
	];

}