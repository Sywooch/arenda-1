<?php

namespace app\components\widgets\attributes\attributes_map;

use yii\web\AssetBundle;
use yii\web\View;

class AttributesMapWidgetAssets extends AssetBundle
{
    public $sourcePath = '@app/components/widgets/attributes/attributes_map/assets';
    public $js = [
        'js.js'
    ];
    public $css = [
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = array(
        'position' => View::POS_END
    );

}