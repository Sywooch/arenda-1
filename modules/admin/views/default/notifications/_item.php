<?php

use app\components\extend\Html;
use app\models\Notifications;

/* @var $model app\models\Notifications */
?>


<div style="border:1px solid #adadad" class="panel panel-<?= $model->status == Notifications::STATUS_NEW ? 'success' : 'info' ?>">
    <div class="panel-heading">
        <div class="panel-title">
            <?= $model->getDate('date_created'); ?>
            <div class="pull-right">
                <?php
                $tmp = '';
                foreach ($model->data as $key => $value) {
                    $tmp .= $key . ' : ' . $value . '<br/>';
                }
                ?>
                <a 
                    title="Дополнительная информация" 
                    href="#" 
                    onclick="return false" 
                    data-html="true" 
                    type="button" 
                    class="glyphicon glyphicon-exclamation-sign text-2x" 
                    data-container="body" 
                    data-toggle="popover" 
                    data-placement="left" 
                    data-content="<?= $tmp; ?>">

                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= $model->message; ?>
    </div>
</div>

<?php
$model->markAsViewed();
