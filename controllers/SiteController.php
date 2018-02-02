<?php

namespace app\controllers;

use app\components\extend\FrontendController;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;
use app\models\Files;
use app\models\forms\LoginForm;
use app\models\forms\PasswordResetRequestForm;
use app\models\forms\ResetPasswordForm;
use app\models\Pages;
use app\models\User;
use Imagine\Image\ImageInterface;
use yii\base\InvalidParamException;
use Yii;
use yii\caching\FileCache;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\imagine\Image;
use yii\web\BadRequestHttpException;
use yii\web\View;

class SiteController extends FrontendController
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => ['logout', 'notifications'],
				'rules' => [
					[
						'actions' => ['logout', 'notifications'],
						'allow'   => true,
						'roles'   => ['@'],
					]
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			/*'error' => [
				'class' => 'yii\web\ErrorAction',
			],*/
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionError()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception instanceof \yii\web\NotFoundHttpException) {

			$url = Yii::$app->request->pathInfo;

			if (($model = Pages::find()->where(['url' => $url, 'status' => Pages::STATUS_ACTIVE])->one()) !== null) {
				$this->layout = 'main_pages';

				return $this->render('//pages/view', [
					'model' => $model,
				]);
			}
		}

		return (new \yii\web\ErrorAction('error', $this))->run();
	}

	public function actionImage($d)
	{
		$data = Json::decode(base64_decode(base64_decode($d)));
		$filePath = (@$data['filePath'] && is_file(@$data['filePath'])) ? $data['filePath'] : CommonHelper::file()->getPath() . Files::DEFAULT_NO_IMAGE;

		$w = (int)@$data['width'];
		$h = (int)@$data['height'];
//        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
		$mode = ImageInterface::THUMBNAIL_OUTBOUND;
		$quality = 100;
		$cacheDuration = (((60 * 60 * 24) * 1)/* 1 day */);
		$hash = md5($filePath . $w . $h . $mode . $quality . $cacheDuration);
		$cache = new FileCache();
		if ($img = $cache->get($hash)) {
			return $img;
		}
		ob_start();
		Image::thumbnail($filePath, $w, $h, $mode)->show('jpg', [
			'quality' => $quality,
		]);
		$img = ob_get_contents();
		ob_end_clean();
		$cache->add($hash, $img, $cacheDuration/* cachce duration */);

		return $img;
	}

	public function actionTest()
	{
		Yii::$app->mailer->compose()
			->setFrom(CommonHelper::data()->getParam('supportEmail'))
			->setTo('mailer@nikoland.ru')
			->setSubject('Вы зарегистрировались на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
			->send();
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->redirect(Url::to(['/real-estate']));
		}

		return $this->render('index');
	}

	/**
	 * SignUp
	 * @return type
	 */
	public function actionSignup()
	{
		$model = $this->signupForm;
		$post = Yii::$app->request->post();

		if (array_key_exists('SignupForm', $post) && $model->load($post)) {

			$this->ajaxValidation($model);

			if ($user = $model->signup()) {
				if (Yii::$app->getUser()->login($user)) {
					if ($user->isCustomer) {
						return $this->redirect('/user/index');// /settings/personal-info
					} else {
						return $this->redirect('/user/index');
					}
				}
			} else {
				return Yii::$app->view->registerJs('mes("' . $model->role . '");$("*[data-id-modal=\'registration\']").trigger("click");', View::POS_READY);
			}
		}
	}

	public function actionSignupSms()
	{
		$phone = Yii::$app->request->post('phone', null);
		if ($phone !== null && $phone) {
			$code = $this->genererateRandomNumbers();
			//$code = '0000';

			Yii::$app->session->set(User::SESSION_SMS_SIGNUP_KEY, $code);

			\Yii::$app->sms->sms_send($phone, 'Код подтверждения: ' . $code, 'arenda');
		}

		echo Yii::$app->session->get(User::SESSION_SMS_SIGNUP_KEY);
		//echo 'ok';
	}

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            $this->ajaxValidation($model);

            if ($model->login()) {
                return $this->goBack(Url::to(['/user/index']));
                //return $this->redirect(Yii::$app->request->referrer);
            } else {
                return Yii::$app->view->registerJs('$("*[data-id-modal=\'login\']").trigger("click");',
                    View::POS_READY);
            }
        }
    }

    /**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();

		$formData = Yii::$app->request->post();
		$method = Yii::$app->request->getMethod();

		if ($method == 'POST') {
			if ($model->load($formData)) {
				$this->ajaxValidation($model);
			}
		} else if ($method == 'PUT') {

			if (isset($formData['data'])) {

				$params = [];
				parse_str($formData['data'], $params);

				if ($model->load($params)) {
					if ($model->validate()) {
						if ($model->sendEmail('site/reset-password')) {
                             echo 'На Ваш Email отправлена ссылка для Восстановления пароля';
						}
					} else {
						echo 'Произошла неизвестная ошибка';
					}
				}
			}
		}

		Yii::$app->end();
	}

	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->getSession()->setFlash('success', 'Пароль успешно изменен');

			return $this->goHome();
		}

		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}

	function actionNotifications()
	{
		return $this->render('notifications', [
			'dataProvider' => Yii::$app->user->identity->getNotifications(),
		]);
	}

	function actionUnderConstruction()
	{
		return $this->render('under-construction');
	}

    public function actionInvitelessor()
    {
        if (array_key_exists('requests', $_GET)) {
            if(count($_GET['requests'])==1 AND empty($_GET['requests'][0]['email'])){
                Yii::$app->getSession()->setFlash('success', 'Пожалуйста, укажите почту!');
                return $this->redirect('/invite-lord#inviteit');
            }
            foreach ($_GET['requests'] as $request){
                if(!empty($request['email'])){
                    if(Yii::$app->user->isGuest){
                        $user = null;
                    }else{
                        $user = User::findOne(Yii::$app->user->id);
                    }

                    Yii::$app->mailer->compose('invite-lord', ['user' => $user])
                        ->setFrom(CommonHelper::data()->getParam('supportEmail'))
                        ->setTo($request['email'])
                        ->setSubject('Новое приглашение на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
                        ->send();
                }
            }
            Yii::$app->getSession()->setFlash('success', 'Приглашение отправлен!');
            return $this->redirect('/invite-lord');
        }
    }

    public function actionContacts(){
        $model = $this->contactForm;
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            //$this->ajaxValidation($model);
            if($model->contact($model)){
                Yii::$app->getSession()->setFlash('success', 'Ваше сообщение отправлено');
            }else{
                Yii::$app->getSession()->setFlash('success', 'Ошибка, сообщение не отправлено!<br/>Попробуйте снова');
            }

        }
        return $this->redirect('/contacts');
    }
}
