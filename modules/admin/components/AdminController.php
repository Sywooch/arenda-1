<?php

namespace app\modules\admin\components;

use yii;
use app\assets\Asset;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\extend\Controller;

class AdminController extends Controller
{
    public function init()
    {
        $init = parent::init();
        if (yii::$app->user->isGuest) {
            $this->layout = 'login';
        } else {
            if (!yii::$app->user->identity->hasRole('admin')) {
                Yii::$app->getSession()->setFlash('error', 'Вам не разрешено производить данное действие!');
                yii::$app->user->logout(false);
            }
        }
        return $init;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error', 'resetPassword', 'requestPasswordReset', 'login', 'captcha', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [$this->action->id],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function getFlashMessages()
    {
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            $js = "$(function(){ mes('$message','" . ($key == 'error' ? 'danger' : $key) . "'); });";
            $exp = new yii\web\JsExpression($js);
            yii::$app->view->registerJs($exp);
        }
    }

}