<?php

namespace app\controllers;

use app\components\extend\FrontendCabinetController;
use app\models\behaviors\payment_methods\PaymentMethodsCardBehavior;
use app\models\search\PaymentMethodsAccountsSearch;
use app\models\search\PaymentMethodsCardsSearch;
use Yii;
use app\models\PaymentMethods;
use yii\filters\VerbFilter;
use app\models\User;
use yii\filters\AccessControl;
use app\components\helpers\CommonHelper;
use yii\helpers\ArrayHelper;

/**
 * PaymentMethodsController implements the CRUD actions for PaymentMethods model.
 */
class PaymentMethodsController extends FrontendCabinetController
{
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
						'roles' => [User::ROLE_LESSOR, User::ROLE_MANAGER, User::ROLE_CUSTOMER],
					],
				],
			],
		];
	}

	/**
	 * Lists all PaymentMethods models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModelCards = new PaymentMethodsCardsSearch();
		$searchModelAccounts = new PaymentMethodsAccountsSearch();

		$dataProviderCards = $searchModelCards->search(array_merge(Yii::$app->request->queryParams, ['user_id' => Yii::$app->user->id]));
		$dataProviderAccounts = $searchModelAccounts->search(array_merge(Yii::$app->request->queryParams, ['user_id' => Yii::$app->user->id]));

		$user = Yii::$app->user->identity;
		$inplatFormLinkUrl = Yii::$app->inplat->formLinkUrl($user);

		return $this->render('index', [
			'searchModelCards'     => $searchModelCards,
			'dataProviderCards'    => $dataProviderCards,
			'searchModelAccounts'  => $searchModelAccounts,
			'dataProviderAccounts' => $dataProviderAccounts,
			'inplatFormLinkUrl'    => $inplatFormLinkUrl,
		]);
	}

	public function updateLinks()
	{
		$user = Yii::$app->user->identity;
		$links = Yii::$app->inplat->getLinks($user);

		PaymentMethods::deleteAll(['user_id' => $user->id, 'type' => PaymentMethods::TYPE_CARD]);

		if (!empty($links)) {
			foreach ($links as $link) {
				if ($link->type == 'card') {
					$card = new PaymentMethods();
					$card->setAttributes([
						'user_id' => $user->id,
						'type'    => PaymentMethods::TYPE_CARD,
						'link_id' => $link->link_id,
						'data'    => [PaymentMethodsCardBehavior::CARD_NUMBER => $link->alias],
						'status'  => PaymentMethods::STATUS_ACTIVE,
					]);
					$card->save();
				}
			}
		}
	}

	public function actionUpdateLinks()
	{
		$this->updateLinks();

		return 'ok';
	}

	/**
	 * Creates a new PaymentMethods model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 * @return mixed
	 */
	public function actionCreate($type)
	{
		$model = new PaymentMethods();
		$model->type = (int)$type;

		$this->saveModel($model);

		return $this->renderAjax('create', [
			'model' => $model,
		]);
	}

	/**
	 * save model data
	 * @param PaymentMethods $model
	 */
	public function saveModel($model)
	{
		$formData = Yii::$app->request->post();
		$method = Yii::$app->request->getMethod();

		if ($method == 'POST') {
			if ($model->load($formData)) {
				if ($model->isNewRecord || !$model->user_id) {
					$model->user_id = Yii::$app->user->id;
					$model->status = PaymentMethods::STATUS_ACTIVE;
				}
				$this->ajaxValidation($model);
			}
		} else if ($method == 'PUT') {

			if (isset($formData['data'])) {

				$params = [];
				parse_str($formData['data'], $params);

				if ($model->load($params)) {
					if ($model->isNewRecord || !$model->user_id) {
						$model->user_id = Yii::$app->user->id;
						$model->status = PaymentMethods::STATUS_ACTIVE;
					}

					if ($model->validate() && $model->save()) {
						echo 'success';
						Yii::$app->end();
					} else {
						var_dump($model->getErrors());
						Yii::$app->end();
					}
				}
			}
		}
	}

	/**
	 * Updates an existing PaymentMethods model.
	 * If update is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		$this->saveModel($model);

		return $this->renderAjax('update', [
			'model' => $model,
		]);
	}

	/**
	 * Finds the PaymentMethods model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return PaymentMethods the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = PaymentMethods::find()->where([
				'id' => (int)$id, 'user_id' => Yii::$app->user->id,
			])->one()) !== null
		) {
			return $model;
		} else {
			$this->throwNoPageFound();
		}
	}

	/**
	 * Deletes an existing PaymentMethods model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);

		$method = Yii::$app->request->getMethod();

		if ($method == 'POST') {
			if ($model->type == PaymentMethods::TYPE_CARD) {
				Yii::$app->inplat->getUnlink($model->link_id);
				$this->updateLinks();
			} else {
				$model->delete();
			}
			echo 'success';
			Yii::$app->end();
		}

		return $this->renderAjax('delete', [
			'model' => $model,
		]);
	}

}
