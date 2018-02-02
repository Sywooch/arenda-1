<?php

namespace app\components\extend;

use app\models\Applications;
use app\models\LeaseContractParticipants;
use app\models\ScreeningRequest;
use Yii;

class FrontendCabinetController extends \app\components\extend\FrontendController
{
    public function init()
    {
        parent::init();

        // Setting different page base class based on users role
        if (!Yii::$app->user->isGuest) {
            $identity = Yii::$app->user->identity;
            if ($identity->isCustomer) {
                $this->pageBaseClass .= ' page-lk page-renter';
                $this->headerMenuView = 'menu_lk_renter';
                Yii::$app->params['new_lc_part_counter'] = LeaseContractParticipants::getNewCount();
                Yii::$app->params['new_scrining'] = ScreeningRequest::getNewCount();
            } else {
                $this->pageBaseClass .= ' page-lk page-lord';
                $this->headerMenuView = 'menu_lk_lord';

                Yii::$app->params['new_app_counter'] = Applications::getNewCount();
            }
        }

    }

}
