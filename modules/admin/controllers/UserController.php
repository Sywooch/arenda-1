<?php

namespace app\modules\admin\controllers;

use app\models\UserPassport;
use yii;
use app\models\User;
use app\models\search\UserSearch;
use app\modules\admin\components\AdminController as Controller;
use yii\filters\VerbFilter;
use app\components\helpers\CommonHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new User();
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $this->saveModel($model);
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->getRoles($model->primaryKey);
        $model->assignedRoles = array_combine(array_keys($model->assignedRoles), array_keys($model->assignedRoles));
        $this->saveModel($model);
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * save model data
     * @param User $model
     * @return User
     */
    public function saveModel($model)
    {
        /* @var $model User */
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $model->assignedRoles = $post['User']['assignedRoles'];
            $this->ajaxValidation($model);
            if ($model->validate() && $model->save()) {
                if (is_array($model->assignedRoles) && count($model->assignedRoles) > 0) {
                    yii::$app->authManager->revokeAll($model->primaryKey);
                    foreach ($model->assignedRoles as $role) {
                        $model->assignRole($role, $model->getRoleLabels());
                    }
                }
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->getSession()->setFlash('success', 'Данные удалены!');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Не удалось удалить данные!');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            $this->throwNoPageFound();
        }
    }

    /**
     *
     *
     */
    public function actionVerify($id)
    {
        $model = UserPassport::find()->where(['user_id'=>$id])->one();
        if ($model=== null) {
            $model = new UserPassport();
            $model->user_id = $id;
        }

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $this->ajaxValidation($model);
            if ($model->validate() && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Данные сохранены!');
                return $this->redirect(['view', 'id' => $id]);
            } else {
                Yii::$app->getSession()->setFlash('error', CommonHelper::formatModelErrors($model));
                $this->refresh();
            }
        }

        return $this->render('verify', [
            'model' => $model,
        ]);

    }

}