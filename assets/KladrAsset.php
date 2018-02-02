<?php

namespace app\assets;

use yii\web\AssetBundle;

class KladrAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.kladr';

	public $css = [
        'jquery.kladr.min.css',
    ];

	public $js = [
        'jquery.kladr.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
