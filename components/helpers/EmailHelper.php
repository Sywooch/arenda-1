<?php

namespace app\components\helpers;

use yii;

class EmailHelper
{

    /**
     * 
     * @param string $to
     * @param string $subject
     * @param array $render ['view'=>'viewFileName' , 'params' => ['param1'=>'value1','param2'=>'value2']]
     * @param array $from
     * @return \yii\mail\MessageInterface
     */
    public static function compose($to, $subject, $render, $from = null)
    {
        $dataHelper = new DataHelper();
        if (!$from) {
            $from = $dataHelper->getParam('adminEmail', $dataHelper->getParam('tld', 'admin@arenda.ru'));
        }
        if (!array_key_exists('view', $render))
            return false;
        $mail = yii::$app->mailer->compose($render['view'], (array_key_exists('params', $render) ? $render['params'] : []))
                ->setFrom($from)
                ->setTo($to)
                ->setSubject($subject);
        return $mail;
    }

    /**
     * send text/html by default view (/mail/default.php)
     * @param string $to
     * @param string $subject
     * @param string $content content
     * @param array $from
     * @return \yii\mail\MessageInterface
     */
    public static function composeHtml($to, $subject, $content, $from = null)
    {
        return self::compose($to, $subject, [
                    'view' => 'default',
                    'params' => [
                        'message' => $content
                    ]
                        ], $from);
    }

}
