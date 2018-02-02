<?php

namespace app\modules\admin\controllers;


use app\modules\admin\components\AdminController;
use app\models\Config;
use \Yii;
class AgreementController extends AdminController
{
    public function actionIndex()
    {
        $config = Config::findOne(1);
        $config->scenario = Config::SCENARIO_AGREEMENT;
        return $this->render('index', [
            'config' => $config,
        ]);
    }
    
    public function actionUpdate() {
        $config = Config::findOne(1);
        $config->scenario = Config::SCENARIO_AGREEMENT;
        
        $config->load(Yii::$app->request->post());
        $config->save();
        
        return $this->redirect('index');
    }
}
