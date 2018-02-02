<?php

namespace app\modules\admin\controllers;

use yii;
use app\models\Metro;
use app\models\search\MetroSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\admin\components\AdminController;
use app\components\helpers\CommonHelper;

/**
 * MetroController implements the CRUD actions for Metro model.
 */
class MetroController extends AdminController
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
     * Lists all Metro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MetroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Metro model.
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
     * Creates a new Metro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Metro();
        $this->saveModel($model);
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Metro model.
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
     * @param Metro $model
     * @return Metro
     */
    public function saveModel($model)
    {
        /* @var $model Metro */
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
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
     * Deletes an existing Metro model.
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
     * Finds the Metro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Metro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Metro::findOne($id)) !== null) {
            return $model;
        } else {
            $this->throwNoPageFound();
        }
    }

}