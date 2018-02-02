<?php

namespace app\controllers;

use yii;
use app\models\User;
use app\models\ApplicationRoommates;
use app\models\search\ApplicationRoommatesSearch;
use app\components\extend\FrontendController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use app\components\helpers\CommonHelper;
use app\models\Applications;
use app\models\Ads;

/**
 * ApplicationRoommatesController implements the CRUD actions for ApplicationRoommates model.
 */
class ApplicationRoommatesController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all ApplicationRoommates models.
     * @return mixed
     */
    public function actionIndex($ad)
    {
        $model = new ApplicationRoommates();
        $model->setApplication((int) $ad, yii::$app->user->id);
        $this->saveModel($model);
        $searchModel = new ApplicationRoommatesSearch();
        $dataProvider = $searchModel->searchByAd(Yii::$app->request->queryParams, (int) $ad);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'ad' => (int) $ad,
                    'model' => $model,
        ]);
    }

    /**
     * save model data
     * @param ApplicationRoommates $model
     * @return ApplicationRoommates
     */
    public function saveModel($model)
    {
        if (yii::$app->request->isAjax && yii::$app->request->post('type') == 'save') {
            parse_str(yii::$app->request->post('data'), $post);
            if ((int) (@$post['id']) > 0) {
                $model = $this->findModel($post['id']);
            }
            $result = ['response' => 'error'];
            if ($model->load(['ApplicationRoommates' => $post])) {
                if ($model->validate() && $model->save()) {
                    $result['response'] = 'success';
                    $result['message'] = 'Данные сохранены!';
                } else {
                    $result['message'] = CommonHelper::formatModelErrors($model);
                }
            }
            die(Json::encode($result));
        }
        return $model;
    }

    /**
     * Deletes an existing ApplicationRoommates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $result = ['response' => 'success', 'message' => 'Запись удален успешно!'];
        die(Json::encode($result));
    }

    /**
     * Finds the ApplicationRoommates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApplicationRoommates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $id = (int) $id;
        if ($id == 0) {
            return new ApplicationRoommates;
        }
        $q = ApplicationRoommates::find();
        $q->where([ApplicationRoommates::tableName() . '."id"' => $id]);
        $q->joinWith(['application' => function($query) {
                /* @var $query \yii\db\ActiveQuery */
                $query->where([Applications::tableName() . '."user_id"' => yii::$app->user->id]);
                return $query;
            }]);
        if (($model = $q->one()) !== null) {
            return $model;
        } else {
            $this->throwNoPageFound();
        }
    }

}
