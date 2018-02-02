<?php

namespace app\controllers;

use yii;
use app\models\Pages;
use app\components\extend\FrontendController;

class PagesController extends FrontendController
{
	public $layout = 'main_pages';

    /**
     * view page action.
     * @return string
     */
    public function actionView($url = 'index')
    {
        return $this->render('view', [
            'model' => $this->findModel($url)
        ]);
    }

    /**
     * Finds the RealEstate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($url)
    {
        if (($model = Pages::find()->where(['url' => $url, 'status' => Pages::STATUS_ACTIVE])->one()) !== null) {
            return $model;
        } else {
            $this->throwNoPageFound();
        }
    }

}
