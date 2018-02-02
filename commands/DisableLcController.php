<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\LeaseContracts;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DisableLcController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        echo "Start: \n\r";
        $lcs = LeaseContracts::find()->where(['status' => LeaseContracts::STATUS_IN_DISABLE])->andWhere('date_disable<'.strtotime('now'))->all();
        if($lcs!=null){
            foreach ($lcs as $lc) {
                echo $lc->id;
                echo " \n\r";
                echo $lc->status;
                echo " \n\r";
                $lin = LeaseContracts::find()->alias('t')->joinWith(['participants'])->where(['t.id'=>$lc->id])->one();
                $lin->status = LeaseContracts::STATUS_DISABLED;
                $lin->date_disable = null;
                if($lin->update(false)){
                    $lin->sendContractDisableMessage($lc->user_id);
                    $lin->sendContractDisableMessage();
                }
            }
        }
        echo 'end';
    }
}
