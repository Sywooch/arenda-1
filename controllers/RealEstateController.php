<?php

namespace app\controllers;

use app\components\extend\FrontendCabinetController;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;
use app\models\forms\EstateUserForm;
use app\models\forms\InviteCustomerForm;
use app\models\UserPassport;
use yii\filters\AccessControl;
use yii;
use app\models\User;
use app\models\RealEstate;
use app\models\search\RealEstateSearch;
use yii\filters\VerbFilter;

/**
 * RealEstateController implements the CRUD actions for RealEstate model.
 */
class RealEstateController extends FrontendCabinetController
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
						'roles' => [User::ROLE_LESSOR, User::ROLE_MANAGER, User::ROLE_CUSTOMER],
					],
				],
			],
		]);
	}

	/**
	 * Lists all RealEstate models.
	 * @return mixed
	 */
	public function actionIndex()
	{

		$searchModel = new RealEstateSearch();
		$searchModel->user_id = Yii::$app->user->id;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$user = Yii::$app->user->identity;
		$inviteCustomerForm = new InviteCustomerForm();
		if(isset(Yii::$app->request->isPost)){
			$post = Yii::$app->request->post();
			if(isset($post['InviteCustomerForm'])){
				$inviteCustomerForm->load($post);
				$this->ajaxValidation($inviteCustomerForm);
				if ($inviteCustomerForm->validate()) {
					if ($inviteCustomerForm->send(['sender' => $user])) {
						Yii::$app->getSession()->setFlash('success', 'Приглашение отправлено успешно!');
					} else {
						Yii::$app->getSession()->setFlash('error', 'Не удалось отправить приглашение!');
					}
					$inviteCustomerForm = new InviteCustomerForm();
				}
			}
		}

		return $this->render('//_general/cabinet_wrapper', [
			'view'                => '//real-estate/index',
			'pageHeader'          => 'Недвижимость',
			'pageHeaderAddonView' => '//real-estate/_header_addon',
			'data'                => [
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider,
				'inviteCustomerForm' => $inviteCustomerForm,
				'user'=>$user,
				'realEstate'       => RealEstateSearch::find()
					->where(['user_id' => Yii::$app->user->id])
					->all(),
			],
		]);
	}

	/**
	 * Displays a single RealEstate model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		return $this->render('view', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new RealEstate model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new RealEstate();
        $estateUser = null;
        $pass = UserPassport::find()->where(['user_id'=>Yii::$app->user->id])->one();
        if($pass==null OR ($pass!=null AND $pass->verify!=UserPassport::VERIFY_VERIFIED)){
            $user = User::findOne(Yii::$app->user->id);
            $estateUser = new EstateUserForm();
            $estateUser->first_name = $user->first_name;
            $estateUser->last_name = $user->last_name;
            $estateUser->middle_name = $user->middle_name;
        }
        $this->saveModel($model,$estateUser);

		return $this->renderAjax('create', [
			'model' => $model,
            'estateUser' => $estateUser,
		]);
	}

    public function actionAdd()
    {
        $model = new RealEstate();
        $estateUser = false;
        $pass = UserPassport::find()->where(['user_id'=>Yii::$app->user->id]);
        if($pass==null OR ($pass!=null AND $pass->verify!=UserPassport::VERIFY_VERIFIED)){
            $user = User::findOne(Yii::$app->user->id);
            $estateUser = new EstateUserForm();
            $estateUser->first_name = $user->first_name;
            $estateUser->last_name = $user->last_name;
            $estateUser->middle_name = $user->middle_name;
        }
        $this->saveModel($model);

        return $this->render('add', [
            'model' => $model,
            'estateUser' => $estateUser,
        ]);
    }

    public function actionSaveuser(){
        $user = User::findOne(Yii::$app->user->id);
        $model = new EstateUserForm();
        $formData = Yii::$app->request->post();
        $method = Yii::$app->request->getMethod();

        if ($method == 'POST') {
            if ($model->load($formData)) {
                $user->first_name = $model->first_name;
                $user->last_name = $model->last_name;
                $user->middle_name = $model->middle_name;
                $user->not_editable = 1;
                if($user->save(false)){
                    echo 'ok';
                }else{
                    echo 'error';
                }
                die();
            }
        }
        echo 'error';
    }

	/**
	 * Updates an existing RealEstate model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$this->saveModel($model);
        $estateUser = false;
		return $this->renderAjax('update', [
			'model' => $model,
            'estateUser' => $estateUser,
		]);
	}

	/**
	 * save model data
	 * @param RealEstate $model
	 * @return RealEstate
	 */
	public function saveModel($model,$estateUser=null)
	{
        $prev_address = $model->getFullAddress();
		$formData = Yii::$app->request->post();
		$method = Yii::$app->request->getMethod();

		if ($method == 'POST') {
			if ($model->load($formData)) {
				if ($model->isNewRecord) {
					$model->user_id = Yii::$app->user->id;
				}
				$this->ajaxValidation($model);
			}
			if($estateUser!=null AND $estateUser->load($formData)){
                $this->ajaxValidation($estateUser);
            }
		} else if ($method == 'PUT') {

			if (isset($formData['data'])) {

				$params = [];
				parse_str($formData['data'], $params);

				if ($model->load($params)) {
					if ($model->isNewRecord) {
						$model->user_id = Yii::$app->user->id;
                        $model->check_status = RealEstate::CHECK_STATUS_START;
                    } else {
                        if ($formData['check'])
                            $model->check_status = RealEstate::CHECK_STATUS_START;
                        elseif ($prev_address != $model->getFullAddress())
                            $model->check_status = RealEstate::CHECK_STATUS_NOT_RUN;
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
     * Проверяем изменился ли адрес
     * @param $id
     * @return string
     */
    public function actionAddressChanged($id)
    {
        $model = $this->findModel($id);
        $model2 = new RealEstate();
        $model2->load(Yii::$app->request->post());
        if ($model->getFullAddress() != $model2->getFullAddress())
            return json_encode(['changed' => true]);
        else
            return json_encode(['changed' => false]);
    }

	/**
	 * Deletes an existing RealEstate model.
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

	/**
	 * Finds the RealEstate model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return RealEstate the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = RealEstate::find()->where(['id' => (int)$id, 'user_id' => Yii::$app->user->id])->one()) !== null) {
			return $model;
		} else {
			$this->throwNoPageFound();
		}
	}

	public function actionImageUpload()
	{
		$model = new RealEstate(['scenario' => RealEstate::SCENARIO_FILE_UPLOAD]);
		$model->prepareFilesToSave();

		$file = $model->getFile('cover_image');

		echo yii\helpers\Json::encode([
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
