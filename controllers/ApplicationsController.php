<?php

namespace app\controllers;

use app\components\extend\FrontendCabinetController;
use app\components\extend\Html;
use app\models\forms\AdApplicationSendForm;
use app\models\ScreeningReport;
use app\models\ScreeningRequest;
use yii;
use app\models\Applications;
use app\models\search\ApplicationsSearch;
use app\components\extend\FrontendController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Ads;
use app\models\User;

/**
 * ApplicationsController implements the CRUD actions for Applications model.
 */
class ApplicationsController extends FrontendCabinetController
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		]);
	}

	/**
	 * Lists all Applications models.
	 * @return mixed
	 */
	public function actionIndex($activeAdsOnly = false)
	{
		$user = Yii::$app->user->identity;
		/* @var $user \app\models\User */
		$searchModel = new ApplicationsSearch();
		$searchModel->user_id = $user->id;

		$searchModel->activeAdsOnly = $activeAdsOnly;

		if (!$user->isCustomer) {
			$view = 'manager';
			$dataProvider = $searchModel->searchForManager(Yii::$app->request->queryParams);
		} else {
			$view = 'customer';
			$dataProvider = $searchModel->searchForCustomer(Yii::$app->request->queryParams);
		}

		return $this->render('//_general/cabinet_wrapper', [
			'view'                    => '//applications/' . $view,
			'pageHeader'              => 'Заявки',
			'pageHeaderAddonView'     => '//applications/_header_addon',
			'pageHeaderAddonViewData' => [
				'activeAdsOnly' => $activeAdsOnly,
			],
			'data'                    => [
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider,
			],
		]);
	}

	/**
	 * Lists all Applications models.
	 * @return mixed
	 */
	public function actionViewByAd($id, $archive = false)
	{
		$searchModel = new ApplicationsSearch();
		$searchModel->ad_id = $id;

		$searchModel->status = $archive ? Applications::STATUS_IN_ARCHIVE : Applications::STATUS_NEW;

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$model = Ads::findOne($id);

		return $this->render('//_general/cabinet_full_wrapper', [
			'view'                    => '//applications/view_by_ad',
			'breadcrumbHeader'        => Html::a('Заявки', ['index'], ['class' => 'lk-temp__back']),
			'pageHeader'              => isset($model->estate->title)?$model->estate->title:'',
			'pageSubHeader'           => isset($model->estate)?$model->estate->getFullAddress():'',
			'pageHeaderAddonView'     => '//applications/view_by_add/archive_addon',
			'pageHeaderAddonViewData' => [
				'isArchive' => $archive,
				'model'     => $model,
			],
			'noBackground'            => true,
			'data'                    => [
				'isArchive'    => $archive,
				'ad'           => $model,
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider,
			],
		]);
	}

	/**
	 * Displays a single Applications model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		if (Yii::$app->params['new_app_counter'] > 0) {
			if ($model->is_new == 1) {
				$model->markViewed();
				Yii::$app->params['new_app_counter'] = Applications::getNewCount();
			}
		}

		return $this->render('//_general/cabinet_full_wrapper', [
			'view'             => '//applications/view',
			'breadcrumbHeader' => Html::a('Обратно', ['/applications/view-by-ad', 'id' => $model->ad_id], ['class' => 'lk-temp__back']),
			'noBackground'     => true,
			'data'             => [
				'model' => $model,
			],
		]);

	}

	/**
	 * Creates a new Applications model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($ad_id)
	{
		$formData = Yii::$app->request->post();
		$method = Yii::$app->request->getMethod();

		$model = new AdApplicationSendForm([
			'user_id' => Yii::$app->user->id,
			'ad_id'   => $ad_id,
		]);

		if ($method == 'POST') {
			if ($model->load($formData)) {
				$this->ajaxValidation($model);
			}
		} else if ($method == 'GET') {
			$formData = Yii::$app->request->get();
			$status='error';
			$text = 'Неизвестная ошибка';
			if (isset($formData['data'])) {

				$params = [];
				parse_str($formData['data'], $params);

				if ($model->load($params)) {
					if ($model->validate()) {
						$application = new Applications();
						$application->user_id = $model->user_id;
						$application->ad_id = $model->ad_id;
						$application->comment = $model->comment;
						$application->status = Applications::STATUS_NEW;

						if ($application->save()) {
							$status='success';
							$text = 'Заявка подана';
							$ad = Ads::findOne($ad_id);
							if($ad!=null){
								$adtext = 'Ваша заявка отправлена.<br/>Собственник запросил прохождение проверок. <br/><a href="/scrining/orders">Пройти проверку сейчас</a>';
								if($ad->check_credit_reports==1){
									$rep_credit = ScreeningReport::find()->where([
										'user_id'=>Yii::$app->user->id,
										'type'=>ScreeningReport::TYPE_CREDIT,
										'status'=>ScreeningReport::STATUS_VALID,
									])->one();
									if($rep_credit==null){
										$text = $adtext;
									}else{
										$request = new ScreeningRequest();
										$request->reporter_id = Yii::$app->user->id;
										$request->report_credit_id = $rep_credit->id;
										$email = User::findOne($ad->estate->user_id);
										$request->email = $email->email;
										$request->save(false);
									}
								}
								if($ad->check_biographical_information==1){
									$rep_bio = ScreeningReport::find()->where([
										'user_id'=>Yii::$app->user->id,
										'type'=>ScreeningReport::TYPE_BIO,
										'status'=>ScreeningReport::STATUS_VALID,
									])->one();
									if($rep_bio==null){
										$text = $adtext;
									}else{
										$request = new ScreeningRequest();
										$request->reporter_id = Yii::$app->user->id;
										$request->report_bio_id = $rep_bio->id;
                                        $email = User::findOne($ad->estate->user_id);
                                        $request->email = $email->email;
										$request->save(false);
									}
								}
							}
						}

					} else {
						$status='error';
						$text = implode(",", $model->getErrors());
						//var_dump($model->getErrors());
						//Yii::$app->end();
					}
				}
			}
			$json = [
				'status' => $status,
				'text' => $text,
			];
			echo json_encode($json);
			Yii::$app->end();
		}
	}

	/**
	 * Updates an existing Applications model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$this->saveModel($model);
		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * save model data
	 * @param Applications $model
	 * @return Applications
	 */
	public function saveModel($model)
	{
		if ($model->load(Yii::$app->request->post())) {
			$this->ajaxValidation($model);
			if ($model->validate() && $model->save()) {
				Yii::$app->getSession()->setFlash('success', 'Данные сохранены!');
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				Yii::$app->getSession()->setFlash('error', CommonHelper::formatModelErrors($model));
				$this->refresh();
			}
		}
		return $model;
	}

	/**
	 * Deletes an existing Applications model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id, $refresh = true)
	{
		$model = $this->findModel($id);

		$method = Yii::$app->request->getMethod();

		if ($method == 'POST') {
			$model->delete();

			if (!$refresh) {
				return $this->redirect('/applications');
			}

			echo 'success';
			Yii::$app->end();
		}

		return $this->renderAjax('delete_modal', [
			'model'   => $model,
			'refresh' => $refresh,
		]);
	}

	public function actionArchive($id, $refresh = true)
	{
		$model = $this->findModel($id);

		$method = Yii::$app->request->getMethod();

		if ($method == 'POST') {
			$model->archive();

			if (!$refresh) {
				return $this->redirect('/applications');
			}

			echo 'success';
			Yii::$app->end();
		}

		return $this->renderAjax('archive_modal', [
			'model'   => $model,
			'refresh' => $refresh,
		]);
	}

	/**
	 * Finds the Applications model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Applications the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Applications::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

}
