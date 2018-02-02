<?php

use common\components\facebookAds\FacebookAd;
use common\components\TwillioClient;
use yii\BaseYii;

class Yii extends BaseYii
{
    /**
     * @var \yii\console\Application|Application the application instance
     */
    public static $app;

}

class Application extends \yii\web\Application
{
    /** @var app\components\Inplat */
    public $inplat;
    /** @var Zelenin\yii\extensions\Sms */
    public $sms;
}