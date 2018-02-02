<?php

namespace app\components\extend;

use app\models\forms\ContactForm;
use app\models\forms\PasswordResetRequestForm;
use yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\JsExpression;
use app\components\extend\Html;
use yii\web\View;
use app\models\forms\SignupForm;

class FrontendController extends \app\components\extend\Controller
{
	// Layout page base class
    public $pageBaseClass = '';

	// Menu View
    public $headerMenuView = 'menu_default';

    public $signupForm;
    public $contactForm;
    public $passwordResetRequestForm;

    public function init()
    {
    	parent::init();

        $this->signupForm = new SignupForm();
        $this->contactForm = new ContactForm();
        $this->passwordResetRequestForm = new PasswordResetRequestForm();
    }

}
