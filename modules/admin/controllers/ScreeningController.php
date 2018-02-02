<?php

namespace app\modules\admin\controllers;

use yii;
use app\models\ScreeningReport;
use app\models\search\ScreeningReportSearch;
use app\modules\admin\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ScreeningController extends AdminController
{
    /**
     * Lists all report models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScreeningReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionInvalid($id)
    {
        $model = $this->findModel($id);
        if ($model->isHandled()) {
			return $this->redirect(['index']);
		}
		
		$model->setScenario(ScreeningReport::SCENARIO_INVALID);
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->setInvalid();
            return $this->redirect(['index']);
        }
        
        return $this->render('invalid', [
            'model' => $model,
        ]);
    }
    
    public function actionValid($id)
    {
        $model = $this->findModel($id);
        if ($model->isHandled()) {
			return $this->redirect(['index']);
		}
		
		$model->setScenario(ScreeningReport::SCENARIO_VALID);
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				$model->setValid();
				return $this->redirect(['index']);
			}
        }
        
        return $this->render('valid', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the ScreeningReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ScreeningReport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
