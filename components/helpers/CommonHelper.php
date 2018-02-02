<?php

namespace app\components\helpers;

use Yii;
use app\components\extend\Html;
class CommonHelper
{

    /**
     * 
     * @param object $model
     * @return string
     */
    public static function formatModelErrors($model)
    {
        if (!$model->hasErrors()) {
            return null;
        }
        $tmp = '';
        foreach ($model->getErrors() as $k => $v) {
            $tmp .= $v[0] . '<br/>';
        }

        return $tmp;
    }

    /**
     * get formated price 
     * @param integer $price
     * @param array $params
     */
    public static function getPrice($price, $params = [])
    {
        return number_format($price, 0,'.', ' ').' <span class="rub">&#8381;</span>';//₽
    }

    /**
     * easy usage of session, cookie, params
     * @param array $params
     * @return DataHelper
     */
    public static function data($params = [])
    {
        return (new DataHelper($params));
    }

    /**
     * easy usage of string
     * @param array $params
     * @return StringHelper
     */
    public static function str($params = [])
    {
        return(new StringHelper($params));
    }

    /**
     * easy manipulations with files & folders
     * @param array $params
     * @return FileHelper
     */
    public static function file($params = [])
    {
        return (new FileHelper($params = []));
    }

    /**
     * email
     * @param array $params
     * @return EmailHelper
     */
    public static function email($params = [])
    {
        return(new EmailHelper($params = []));
    }
    
    /**
     * @see Yii::t()
     * @param $number
     * @param null $female
     *
     * @return mixed
     */
    public static final function spellout($number, $female = null) {
        if ($female !== null) {
            $female = ',%spellout-cardinal-feminine';
        }
        
        return Yii::t('app', "{n,spellout{$female}}", ['n' => $number]);
    }
}
