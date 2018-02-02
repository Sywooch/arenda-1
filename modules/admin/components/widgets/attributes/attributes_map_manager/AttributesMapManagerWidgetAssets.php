<?php

namespace app\modules\admin\components\widgets\attributes\attributes_map_manager;

use yii\web\AssetBundle;
use yii\web\View;

class AttributesMapManagerWidgetAssets extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/components/widgets/attributes/attributes_map_manager/assets';
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