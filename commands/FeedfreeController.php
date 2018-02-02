<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\AdPublication;
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
class FeedfreeController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        echo "Start: \n\r";
        $ffd = AdPublication::find()->where(['NOT',['feed_free_date'=>null]])->andWhere('feed_free_date < '.strtotime('now'))->all();
        if($ffd!=null){
            foreach ($ffd as $ff) {
                echo $ff->id;
                echo " ";
                echo $ff->ad_id;
                echo " ";
                echo $ff->board_id;
                echo " \n\r";
                $ff->delete();
            }
        }
        echo 'end';
    }
}
