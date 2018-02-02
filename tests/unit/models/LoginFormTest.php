<?php

namespace tests\models;

use app\models\forms\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'email'    => 'not_existing_email',
            'password' => 'not_existing_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginWrongPassword()
    {
        $this->model = new LoginForm([
            'email'    => 'demo',
            'password' => 'wrong_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('password');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'email'    => 'art@nikoland.ru',
            'password' => '6162201',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('password');
    }

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

}
