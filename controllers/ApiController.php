<?php

namespace app\controllers;

use yii;
use app\components\extend\FrontendController;
use app\models\Ads;

class ApiController extends FrontendController
{

    /**
     * test action.
     *
     * @return string
     */
    public function actionGetFeeds($service)
    {
        $model = Ads::find()->one();
        /* @var $model \app\models\Ads */
        /* @var $model \app\models\behaviors\ads\IntegrationBehavior */
        return $model->integration->generateXML($service);
    }

}
