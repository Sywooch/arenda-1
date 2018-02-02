<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\ScoristaAPI;
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
class VerifyController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $vs = UserPassport::find()->where('verify=0')->andWhere(['not', ['request_id' => null]])->all();
        if($vs!=null){
            foreach ($vs as $v){
                echo $v->user_id;echo " \n\r";
                echo $v->issued_date; echo " \n\r";
                echo $v->request_id; echo " \n\r";
                echo $v->verify; echo " \n\r";
                $sc = new ScoristaAPI();
                $result = $sc->checkRequest($v->request_id); 
                if(isset($result->status) AND $result->status=='DONE'){
                    echo ' done';
                    if(isset($result->data->decision->decisionBinnar) AND $result->data->decision->decisionBinnar==1){
                        $passport = UserPassport::find()->where(['user_id'=>$v->user_id])->one();
                        $passport->verify = UserPassport::VERIFY_VERIFIED;
                        $passport->update(false);
                        
                        UserPassport::setValid($v->user_id);
                    }else{
                        $passport = UserPassport::find()->where(['user_id'=>$v->user_id])->one();
                        $passport->verify = UserPassport::VERIFY_UNVERIFIED;
                        $passport->update(false);
                        
                        UserPassport::setInvalid($v->user_id);
                    }  
                }else{
                    echo ' checking..';
                }
            }
        }
    }
}
