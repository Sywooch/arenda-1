<?php

namespace app\components;

use Yii;

class Users extends \yii\web\User
{
    public $_access;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

}