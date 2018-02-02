<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\AttributesMap;
use app\models\search\AttributesMapSearch;
use app\modules\admin\components\AdminController as Controller;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use app\components\helpers\CommonHelper;

/**
 * AttributesMapController implements the CRUD actions for AttributesMap model.
 */
class AttributesMapController extends Controller
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
     * Lists all AttributesMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttributesMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new AttributesMap();
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single AttributesMap model.
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
     * Updates an existing AttributesMap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSave()
    {
        $this->saveModel();
    }

    /**
     * save model data
     * @param AttributesMap $model
     * @return AttributesMap
     */
    public function saveModel()
    {
        /* @var $model AttributesMap */
        $ar = ['result' => 'error', 'message' => 'Ошибка'];
        $post = Yii::$app->request->post();
        parse_str(@$post['data'], $data);
        $model = (int) @$data['AttributesMap']['id'] > 0 ? $this->findModel((int) $data['AttributesMap']['id']) : new AttributesMap;
        $ar['data'] = $data;
        $ar['model'] = $model;
        if (isset($data) && $data) {
            if ($model->load($data))
                if ($model->validate() && $model->save()) {
                    $ar['result'] = 'success';
                    $ar['message'] = 'Данные сохранены!';
                } else {
                    $ar['result'] = 'error';
                    $ar['message'] = CommonHelper::formatModelErrors($model);
                }
            $ar['model'] = $model->attributes;
        }
        die(Json::encode($ar));
    }

    /**
     * Deletes an existing AttributesMap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $ar = ['result' => 'error', 'message' => 'Ошибка'];
        if ($model->delete()) {
            $ar['result'] = 'success';
            $ar['message'] = 'Данные удалены!';
        }
        die(Json::encode($ar));
    }

    /**
     * Finds the AttributesMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttributesMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AttributesMap::findOne($id)) !== null) {
            return $model;
        } else {
            $this->throwNoPageFound();
        }
    }

}