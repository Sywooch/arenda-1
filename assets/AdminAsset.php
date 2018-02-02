<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/public/admin/css/nifty.min.css',
        '/public/admin/css/demo/nifty-demo-icons.min.css',
        '/public/admin/plugins/font-awesome/css/font-awesome.min.css',
        '/public/admin/plugins/animate-css/animate.min.css',
        '/public/admin/plugins/morris-js/morris.min.css',
        '/public/admin/plugins/switchery/switchery.min.css',
        '/public/admin/plugins/bootstrap-select/bootstrap-select.min.css',
        '/public/admin/css/demo/nifty-demo.min.css',
        '/public/admin/css/site.css',
    ];
    public $js = [
        '/public/common/js/yii.js',
        '/public/app/plugins/bootbox/bootbox.min.js',
        '/public/admin/js/bootstrap.min.js',
        '/public/admin/plugins/pace/pace.min.js',
        '/public/admin/plugins/fast-click/fastclick.min.js',
        '/public/admin/js/nifty.min.js',
        '/public/admin/plugins/morris-js/morris.min.js',
        '/public/admin/plugins/morris-js/raphael-js/raphael.min.js',
        '/public/admin/plugins/sparkline/jquery.sparkline.min.js',
        '/public/admin/plugins/skycons/skycons.min.js',
        '/public/admin/plugins/switchery/switchery.min.js',
        '/public/admin/plugins/bootstrap-select/bootstrap-select.min.js',
        //'/public/admin/js/demo/nifty-demo.min.js',
        '/public/admin/js/demo/dashboard.js',
        '/public/common/js/helper.js',
        '/public/admin/js/js.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];

    public function init()
    {
        \Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = [
            'sourcePath' => null,
            'js' => ['jquery.js' => '/public/admin/js/jquery-2.2.1.min.js'],
        ];
        parent::init();
    }

}
