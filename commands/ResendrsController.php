<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\ScoristaAPI;
use app\models\ScreeningReport;
use app\models\UserPassport;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ResendrsController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        echo 'Start'; echo " \n\r";
        $vs = UserPassport::find()->where('is_scorista_wait=1')->all();//->andWhere(['request_id' => null])
        if($vs!=null){
            foreach ($vs as $v){
                echo $v->user_id;echo " \n\r";
                echo $v->issued_date; echo " \n\r";
                $verify = new ScoristaAPI();
                $req = $verify->request(null,$v->user_id);
                if(isset($req->status) AND $req->status=='OK'){
                    $passport = UserPassport::find()->where(['user_id'=>$v->user_id])->one();
                    $passport->request_id = $req->requestid;
                    $passport->verify = UserPassport::VERIFY_WAIT;
                    $passport->is_scorista_wait = 0;
                    $passport->update(false);
                    UserPassport::setVerify();
                }
            }
        }
        $srs = ScreeningReport::find()->where('is_scorista_wait=1')->all();//->andWhere(['request_id' => null])
        if($srs!=null) {
            foreach ($srs as $report) {
                echo $report->id;echo " \n\r";
                $scorista = new ScoristaAPI();
                $req = $scorista->request($report->id);
                if(isset($req->status) AND $req->status=='OK'){
                    $report->request_id = $req->requestid;
                    $report->is_scorista_wait = 0;
                    $report->update(false);
                }
            }
        }
        echo 'End'; echo " \n\r";
    }
}
