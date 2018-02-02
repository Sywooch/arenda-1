<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        default
        '/public/app/plugins/notify/animate.css',
//        plugins
        '/public/app/bower_components/normalize.css/normalize.css',
        '/public/app/bower_components/slick-carousel/slick/slick.css',
        '/public/app/bower_components/slick-carousel/slick/slick-theme.css',
        //'/public/app/bower_components/air-datepicker/dist/css/datepicker.css',
        '/public/app/bower_components/arcticmodalbw/arcticmodal/jquery.arcticmodal.css',
        '/public/app/bower_components/cropper/dist/cropper.css',
//        styles
        '/public/app/css/site/styles.css',
        '/public/app/css/site.css',
    ];
    public $js = [
//        default
        //'/public/common/js/yii.js',
        '/public/app/plugins/bootbox/bootbox.min.js',
        '/public/app/plugins/notify/bootstrap-notify.js',
        '/public/common/js/helper.js',
        '/public/app/js/helper.js',
        '/public/app/js/ads.js',
        '/public/app/js/js.js',
//        plugins
        '/public/app/bower_components/slick-carousel/slick/slick.min.js',
        '/public/app/bower_components/jquery-touchswipe/jquery.touchSwipe.js',
        //'/public/app/bower_components/air-datepicker/dist/js/datepicker.js',
        '/public/app/bower_components/arcticmodalbw/arcticmodal/jquery.arcticmodal.min.js',
        '/public/app/bower_components/jquery.inputmask/dist/inputmask/inputmask.js',
        '/public/app/bower_components/clipboard/dist/clipboard.js',
        '/public/app/bower_components/html.sortable/dist/html.sortable.js',
        '/public/app/bower_components/cropper/dist/cropper.js',
//        scripts
        '/public/app/js/site/scripts/jquery.inputmask.bundle.js',
        '/public/app/js/site/scripts/dragLoader.js',
        '/public/app/js/site/scripts/headerController.js',
        '/public/app/js/site/scripts/imageupload.js',
        '/public/app/js/site/scripts/initMap.js',
        '/public/app/js/site/scripts/lkController.js',
        '/public/app/js/site/scripts/main.js',
        '/public/app/js/site/scripts/new_arg.js',
        '/public/app/js/site/scripts/screen-app.js',
        '/public/app/js/site/scripts/selectController.js',
        '/public/app/js/site/scripts/slider.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\KladrAsset',
        'app\assets\PhotoSwipeAsset',
        'app\components\widgets\AirDatepicker\AirDatepickerAssets',
        //'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $init = parent::init();
        $url = '/public/app/bower_components/modernizr/modernizr.js';
        Yii::$app->view->registerJsFile($url, [
            'position' => yii\web\View::POS_HEAD
        ]);
        return $init;
    }

}
