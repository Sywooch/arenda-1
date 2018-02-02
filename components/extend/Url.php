<?php

namespace app\components\extend;

use yii;
use yii\helpers\Url as BaseUrl;

class Url extends BaseUrl
{
    public static function to($url = '', $scheme = false)
    {
        return parent::to($url, $scheme);
    }

}