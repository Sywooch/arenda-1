<?php

namespace app\assets;

use yii\web\AssetBundle;

class PhotoSwipeAsset extends AssetBundle
{
    public $sourcePath = '@bower/photoswipe/dist';

	public $css = [
        'photoswipe.css',
        'default-skin/default-skin.css',
    ];

	public $js = [
        'photoswipe.min.js',
        'photoswipe-ui-default.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
