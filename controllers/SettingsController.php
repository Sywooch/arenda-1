<?php

namespace app\controllers;

use app\components\extend\FrontendCabinetController;
use app\components\ScoristaAPI;
use app\models\forms\PasswordChangeForm;
use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\UserPassport;
use app\models\UserInfo;
use app\models\UserCustomerInfo;
use app\components\helpers\CommonHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\components\extend\Url;
use app\models\Ads;
use app\models\forms\InviteLessorForm;
use app\models\ScreeningReport;

class SettingsController extends FrontendCabinetController
{
	public $defaultAction = 'personal-info';

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
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionPersonalInfo()
	{
		$this->redirect('/user/profile-update');
		$user = Yii::$app->user->identity;

		$passport = $user->passport;

		if ($passport == null) {
			$passport = new UserPassport();
			$passport->user_id = Yii::$app->user->id;
		}
		if(isset($_GET['deletescan'])){
			if(!empty($passport->scan_passport)){
				$passport->deleteScan();
				$passprt = UserPassport::findOne($passport->id);
				$passprt->scan_passport = '';
				if($passprt->save(false)){
					Yii::$app->getSession()->setFlash('success', 'Скан паспорт удалён');
				}
			}			
			return $this->redirect('/settings/personal-info');
		}

		$formData = Yii::$app->request->post();
		if ($user->load($formData)) {

			$validUser = $user->validate();
			$validPassport = true;

			if ($passport->load($formData)) {
				$validPassport = $passport->validate();
			}

			if ($validUser && $validPassport) {
				$transaction = Yii::$app->db->beginTransaction();

				try {
					if ($user->save() && $passport->save()) {
						$transaction->commit();

						if(isset($_GET['scrining'])){
							$this->redirect('/scrining/create?type='.$_GET['scrining']);
						}else{
							return $this->refresh();
						}

					} else {
						$transaction->rollBack();
					}
				} catch (\Exception $e) {
					$transaction->rollBack();
				}
			}
		}

		return $this->render('settings_wrapper', [
			'view' => 'personal_info',
			'data' => [
				'user'     => $user,
				'passport' => $passport,
			],
		]);
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionNotifications()
	{
		$user = Yii::$app->user->identity;
		$data = $user['data'];
		if(empty($data)){
            $data['notification']=[
                'notificateAboutNewApplications'=>1,
                'notificateAboutCheckPersonalDataAndCreditHist'=>1,
                'notificateCostumerCeckStatus'=>1,
                'notificateCostumerPayment'=>1,
                'notificateBeforeLeaseEnds'=>1,
            ];
            $user['data']=$data;
        }

		if ($user->load(Yii::$app->request->post())) {
			if ($user->validate()) {
				if ($user->save()) {
					Yii::$app->getSession()->setFlash('success', 'Настройки успешно изменены');
					return $this->refresh();
				}
			}
		}

		return $this->render('settings_wrapper', [
			'view' => 'notifications',
			'data' => [
				'user'       => $user,
				'passport'   => $user->passport,
				'isCustomer' => $user->isCustomer,
			],
		]);
	}

	/**
	 * Password change
	 *
	 * @return string
	 */
	public function actionPassword()
	{
		$model = new PasswordChangeForm();

		if ($model->load(Yii::$app->request->post())) {
			$this->ajaxValidation($model);

			if ($model->validate()) {
				$user = Yii::$app->user->identity;

				$user->password = $model->password;

				if ($user->save()) {
					Yii::$app->getSession()->setFlash('success', 'Пароль успешно изменён');
					return $this->refresh();
				}
			}
		}

		return $this->render('settings_wrapper', [
			'view' => 'password',
			'data' => [
				'model' => $model,
			],
		]);
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionAccountDelete()
	{
		$user = Yii::$app->user->identity;

		if ($user->load(Yii::$app->request->post())) {
			if ($user->validate()) {
				if ($user->deleteAccount == 1) {
					$user->setScenario(User::SCENARIO_DELETE_ACCOUNT);

					if ($user->save()) {
						Yii::$app->getSession()->setFlash('success', 'Аккаунт успешно удалён');
						return $this->redirect('/');
					}
				}
			}
		}

		return $this->render('settings_wrapper', [
			'view' => 'account_delete',
			'data' => [
				'user'       => $user,
				'passport'   => $user->passport,
				'isCustomer' => $user->isCustomer,
			],
		]);
	}
	/**
	 * Verify
	 *
	 * @return string
	 */
	public function actionVerify()
	{
		$model = new ScreeningReport();
		if($model->checkPassport()){
			yii::$app->getSession()->setFlash('success', 'Пожалуйста, заполните паспортные данные!');
			return $this->redirect('/settings/personal-info?verify#passport');
		}
		//send request to Scorista
		$verify = new ScoristaAPI();
		$req = $verify->request(null,Yii::$app->user->id);
		$passport = UserPassport::find()->where(['user_id'=>Yii::$app->user->id])->one();
		if($req->status=='OK'){
			$passport->request_id = $req->requestid;
			$passport->update(false);
			yii::$app->getSession()->setFlash('success', 'Данные отправлены!');
			UserPassport::setVerify();
		}else{
			yii::$app->getSession()->setFlash('error', 'Данные не отправлены! Попробуйте позже.');
		}

		return $this->redirect(['personal-info']);
	}
}
