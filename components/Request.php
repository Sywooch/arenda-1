<?php

namespace app\components;

use yii;
use yii\db\Expression;
use app\models\Pages;

class Request extends \yii\web\Request
{

    public $web;
    public $backendUrl;
    private $_queryParams;

    public function resolve()
    {
        if ($pages = Pages::find()->where(['url' => '/' . $this->pathInfo, 'status' => Pages::STATUS_ACTIVE])->one()) {
            return ['/pages/view', ['id' => $pages->primaryKey]];
        }
        if (substr($this->url, 0, 11) === '/profile/u/') {
            $clear = trim(rawurldecode(mb_convert_encoding(str_replace('/profile/u/', '', $this->url), "UTF-8", "auto")));
            return ['/user/profile', ['username' => $clear]];
        }
        if (substr($this->url, 0, 9) === '/profile/') {
            $clear = trim(rawurldecode(mb_convert_encoding(str_replace('/profile/', '', $this->url), "UTF-8", "auto")));
            return ['/user/card', ['page' => $clear]];
        }
        return parent::resolve();
    }

}
