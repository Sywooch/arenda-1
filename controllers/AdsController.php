<?php

namespace app\controllers;

use app\components\extend\FrontendCabinetController;
use app\components\extend\Html;
use app\components\helpers\CommonHelper;
use app\models\AdPublication;
use app\models\Ads;
use app\models\Pay;
use app\models\PayAdItems;
use app\models\RealEstate;
use app\models\search\AdsSearch;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * AdsController implements the CRUD actions for Ads model.
 */
class AdsController extends FrontendCabinetController
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
						'actions' => ['view'],
						'allow'   => true,
					],
					[
						'allow' => true,
						'roles' => [User::ROLE_LESSOR, User::ROLE_MANAGER, User::ROLE_CUSTOMER],
					],
				],
			],
		]);
	}

	/**
	 * Lists all Ads models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new AdsSearch();
		$dataProvider = $searchModel->searchMy(Yii::$app->request->queryParams, Yii::$app->user->id);

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Ads model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id, true);

		$model->addToViewCounter();

		$realEstate = $model->estate;

		$user = $realEstate->user;

		return $this->render('view', [
			'model'      => $model,
			'realEstate' => $realEstate,
			'user'       => $user,
		]);
	}

	/**
	 * Creates a new Ads model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($id = null, $eId = null, $step = 1, $forceSave = null)
	{
		$scenario = null;
		switch ($step) {
			case 1:
				$scenario = Ads::SCENARIO_STEP_1;
				break;
			case 2:
				$scenario = Ads::SCENARIO_STEP_2;
				break;
			case 3:
				$scenario = Ads::SCENARIO_STEP_3;
				break;
			case 4:
				$scenario = Ads::SCENARIO_STEP_4;
				break;
			case 5:
				$scenario = Ads::SCENARIO_STEP_5;
				break;
			case 6:
				$scenario = Ads::SCENARIO_STEP_6;
				break;
		}

		if ($scenario === null) {
			throw new InvalidParamException('Неправильные параметры');
		}

		if ($id === null) {
			$model = new Ads(['scenario' => $scenario]);
			$model->status = Ads::STATUS_DRAFT;

			if ($eId != null) {
				$estate = RealEstate::findOne([
					'id'      => $eId,
					'user_id' => Yii::$app->user->id,
				]);

				if ($estate == null) {
					throw new NotFoundHttpException('Недвижимость не найдена');
				}

				$draftAd = Ads::findOne([
					'real_estate_id' => $estate->id,
					'status'         => [Ads::STATUS_DRAFT, Ads::STATUS_DISABLED],
				]);

				$redirectParams = [
					'create',
				];

				if ($draftAd) {
					$redirectParams['id'] = $draftAd->id;
				} else {
					$model->real_estate_id = $estate->id;

					if ($model->save(false)) {
						$redirectParams['id'] = $model->id;
					} else {
						throw new InvalidParamException('Не удалось создать обьявление');
					}
				}

				$redirectParams['step'] = 1;

				return $this->redirect($redirectParams);
			}
		} else {
			$model = Ads::findOne([
				'id' => $id,
			]);

			if ($model == null) {
				throw new NotFoundHttpException('Обьявление не найдено');
			}

			/*if ($model->status != Ads::STATUS_DRAFT) {
				throw new NotFoundHttpException('Обьявление нельзя редактировать');
			}*/

			$model->scenario = $scenario;
		}
		$model->check_biographical_information = 1;
		$model->check_credit_reports = 1;

		if ($model->load(Yii::$app->request->post())) {
			if ($forceSave !== null && Yii::$app->request->isAjax) {
				// Через AJAX можно сейвить без валидации - например когда хотим уйти на другую страницу
				return $model->save(false);
			}

			$estateValid = true;
			if ($model->estate->load(Yii::$app->request->post())) {
				if ($model->estate->validate()) {
					$model->estate->save(false);
				} else {
					$estateValid = false;
				}
			}

			$formValid = $model->validate() && $estateValid;

			if ($formValid) {
				$transaction = Yii::$app->db->beginTransaction();

				try {
					if ($model->save()) {

						$transaction->commit();

						$nextStep = $step + 1;

						if ($id === null && $model->scenario == Ads::SCENARIO_STEP_1) {
							return $this->redirect(['create', 'id' => $model->id, 'step' => $nextStep]);
						}

						if ($id !== null && $step != Ads::STEPS_COUNT) {
							return $this->redirect(['create', 'id' => $model->id, 'step' => $nextStep]);
						}

						if ($id !== null && $step == Ads::STEPS_COUNT) {

							if ($model->status == Ads::STATUS_DRAFT) {
								$model->status = Ads::STATUS_DISABLED;
							}

							if ($model->save()) {
                                if(is_array($model->place_add_to)){
                                    PayAdItems::deleteAll([
                                        'AND',
                                        ['adId' => $model->id],
                                        ['statusId' => Pay::STATUS_PAY],
                                        ['NOT IN', 'serviceId', $model->place_add_to]
                                    ]);
                                    $user = User::findOne(Yii::$app->user->id);
                                    $model->sendInfoNewPublication($user,$model->place_add_to);
                                }else{
                                    PayAdItems::deleteAll([
                                        'AND',
                                        ['adId' => $model->id],
                                        ['statusId' => Pay::STATUS_PAY]
                                    ]);
                                }
								$model->feedFree($model);

								return $this->redirect(['/real-estate/index']);
							}
						}

					}
				} catch (\Exception $e) {
					$transaction->rollBack();
				}
			}
		}

		return $this->render('//_general/cabinet_full_wrapper', [
			'view'          => '//ads/create',
			'pageHeader'    => 'Новое обьявление',
			'pageSubHeader' => ($model->estate !== null) ? $model->estate->getFullAddress() : '',
			'data'          => [
				'step'     => $step,
				'stepView' => $model->scenario,
				'model'    => $model,
			],
		]);
	}

	/**
	 * Updates an existing Ads model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				if ($model->status == Ads::STATUS_DRAFT) {
					$model->status = Ads::STATUS_DISABLED;
				}

				if ($model->save()) {

                    if(is_array($model->place_add_to)){
                        PayAdItems::deleteAll([
                            'AND',
                            ['adId' => $model->id],
                            ['statusId' => Pay::STATUS_PAY],
                            ['NOT IN', 'serviceId', $model->place_add_to]
                        ]);
                        $user = User::findOne(Yii::$app->user->id);
                        $model->sendInfoNewPublication($user,$model->place_add_to);
                    }else{
                        PayAdItems::deleteAll([
                            'AND',
                            ['adId' => $model->id],
                            ['statusId' => Pay::STATUS_PAY]
                        ]);
                    }
                    $model->feedFree($model);

					return $this->redirect(['/real-estate/index']);
				}
			}
		}

		$canBeActivated = in_array($model->status, [
			Ads::STATUS_DISABLED,
			Ads::STATUS_ACTIVE,
		]);

		return $this->render('//_general/cabinet_full_wrapper', [
			'view'                    => '//ads/update',
			'breadcrumbHeader'        => Html::a('Недвижимость', ['/real-estate'], ['class' => 'lk-temp__back']),
			'pageHeader'              => 'Редактирование объявления',
			'pageSubHeader'           => ($model->estate !== null) ? $model->estate->getFullAddress() : '',
			'pageHeaderAddonView'     => $canBeActivated ? '//ads/form/change_status_addon' : null,
			'pageHeaderAddonViewData' => [
				'model' => $model,
			],
			'data'                    => [
				'model' => $model,
			],
		]);
	}
    public function actionUnpublish($ad,$board)
    {
        $publication = AdPublication::find()->where(['ad_id' => (int)$ad, 'board_id' => (int)$board])->one();
        if ($publication != null) {
            $ads = Ads::findOne((int)$ad);
            $estate = RealEstate::findOne($ads->real_estate_id);
            if ($estate->user_id == Yii::$app->user->id) {
                $publication->delete();
                $user = User::findOne(Yii::$app->user->id);
                $ads->sendInfoUnPublication($user,$board);
            }
        }
        echo 'ok';
    }
	public function actionEditboard($id)
	{
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate() && $model->save()) {
			    if(is_array($model->place_add_to)){
                    PayAdItems::deleteAll([
                        'AND',
                        ['adId' => $model->id],
                        ['statusId' => Pay::STATUS_PAY],
                        ['NOT IN', 'serviceId', $model->place_add_to]
                    ]);
                    $user = User::findOne(Yii::$app->user->id);
                    $model->sendInfoNewPublication($user,$model->place_add_to);
                }else{
                    PayAdItems::deleteAll([
                        'AND',
                        ['adId' => $model->id],
                        ['statusId' => Pay::STATUS_PAY]
                    ]);
                }
                $model->feedFree($model);


				return $this->redirect(['/real-estate/index']);
			}
		}

		return $this->render('//_general/cabinet_full_wrapper', [
			'view'                    => '//ads/editboard',
			'breadcrumbHeader'        => Html::a('Недвижимость', ['/real-estate'], ['class' => 'lk-temp__back']),
			'pageHeader'              => 'Размещение на сайтах недвижимости',
			'pageSubHeader'           => ($model->estate !== null) ? $model->estate->getFullAddress() : '',
			'pageHeaderAddonView'     => '//ads/form/change_status_addon',
			'pageHeaderAddonViewData' => [
				'model' => $model,
			],
			'data'                    => [
				'model' => $model,
			],
		]);
	}

	/**
	 * save model data
	 * @param Ads $model
	 * @return Ads
	 */
	public function saveModel($model)
	{
		if ($model->load(Yii::$app->request->post())) {
			$model->convertDateToUnix();
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
	 * Deletes an existing Ads model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);

		$method = Yii::$app->request->getMethod();

		if ($method == 'POST') {
			$model->delete();
			echo 'success';
			Yii::$app->end();
		}

		return $this->renderAjax('delete', [
			'model' => $model,
		]);
	}

	public function actionChangeStatus($id)
	{
		$model = $this->findModel($id);

		$method = Yii::$app->request->getMethod();

		if ($method == 'POST') {
			if ($model->status == Ads::STATUS_ACTIVE) {
				$model->status = Ads::STATUS_DISABLED;
			} else {
				$model->status = Ads::STATUS_ACTIVE;
			}

			if ($model->save(false)) {
				return $this->redirect(['/real-estate/index']);
			}
		}

		return $this->renderAjax('change_status_modal', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Ads model.
	 * @param integer $id
	 * @param integer $imgId
	 * @return mixed
	 */
	public function actionDeleteImage($id, $imgId)
	{
		$ar = [
			'result'  => 'warning',
			'message' => 'Неизвестная ошибка!',
		];
		$model = Ads::find()->innerJoinWith(['estate'])
			->where([Ads::tableName() . '.id' => (int)$id, RealEstate::tableName() . '.user_id' => Yii::$app->user->id])
			->one();
		$image = $model->getImages()->where(['id' => (int)$imgId])->one();
		/* @var $model \app\models\AdImages */
		if ($image) {
			$deleted = $image->delete();
			$ar = [
				'result'  => ($deleted ? 'success' : 'error'),
				'message' => ($deleted ? 'ok' : 'Не удалось удалить картинку!'),
			];
		}
		return Json::encode($ar);
	}

	/**
	 * Finds the Ads model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @param boolean $public default is false
	 * @return Ads the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id, $public = false)
	{

		if (!Yii::$app->user->isGuest && ($model = Ads::find()->innerJoinWith([
				'estate' => function ($query) {
//                    $query->andWhere(['user_id' => Yii::$app->user->id]);
				},
			])
				->where([Ads::tableName() . '.id' => (int)$id])->one()) !== null
		) {
			return $model;
		} else {
			if ($public && ($model = Ads::find()->where([
					'status' => Ads::STATUS_ACTIVE,
					'id'     => (int)$id,
				])->one()) !== null
			) {
				return $model;
			} else {
				$this->throwNoPageFound();
			}
		}
	}

	public function actionImageUpload($ad_id = null)
	{
		if ($ad_id == null) {
			throw new Exception('Не указан ID объвления');
		}

		$model = Ads::findOne(['id' => $ad_id]);
		$model->scenario = Ads::SCENARIO_FILE_UPLOAD;

		$model->prepareFilesToSave();

		$file = $model->getFile('images');

		echo Json::encode([
			'files' => [[
				'id'           => $file->id,
				'name'         => $file->getPath(),
				'size'         => $file->size,
				'url'          => $file->getImageUrl(),
				'thumbnailUrl' => $file->getImageUrl(['width' => 497, 'height' => 236]),
			]],
		]);
	}
}
