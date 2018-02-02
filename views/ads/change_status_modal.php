<?php

use app\components\extend\Html;
use app\components\extend\Url;
use yii\bootstrap\ActiveForm;
use app\models\PaymentMethods;
use app\models\Ads;

$actionUrl = Url::to(['/ads/change-status', 'id' => $model->id]);

?>
<div class="box-modal modal">
    <div class="modal__close box-modal_close arcticmodal-close"></div>
    <div class="modal__wr">
        <h2 class="modal__title modal--delete">
            Вы действительно хотите <?= ($model->status == Ads::STATUS_ACTIVE) ? 'деактивировать' : 'активировать' ?> выбранное объявление?
        </h2>
        <form id="item-delete-form" action="<?= $actionUrl; ?>" method="POST" class="madal-form modal-delete">
            <?= Html::csrfMetaTags(); ?>
            <?php
            echo Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []);
            ?>
            <?= Html::submitButton('Да', ['class' => 'btn btn-y']) ?>
            <div class="btn btn-pur arcticmodal-close">Нет</div>
        </form>
    </div>
</div>
