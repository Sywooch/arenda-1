<?php

use app\models\Applications;
use app\models\Ads;
use app\components\extend\Html;
use app\components\extend\Url;

?>

<div class="lk-temp-apps-item __app_view __app_view__customer" data-href="<?= Url::to(['/ads/view', 'id' =>$model->ad->id]); ?>">
    <div class="lk-temp-apps-item__top">
        <div class="lk-temp-apps-item__section_f">
            <div class="lk-temp-apps-item__image">
                <?php
                echo $model->ad->cover->file->renderImage([
                    'width'  => 111,
                    'height' => 74,
                ]);
                ?>
            </div>
            <a class="lk-temp-apps-item__info" href="<?= Url::to(['/ads/view', 'id' =>$model->ad->id]); ?>">
                <div class="lk-temp-apps-item__name"><?= $model->ad->estate->title; ?></div>
                <div class="lk-temp-apps-item__text">
                    <div class="lk-temp-apps-item__status <?= ($model->ad->status == Ads::STATUS_ACTIVE) ? '_active' : '_disable'; ?>"></div>
                    <?= number_format($model->ad->rent_cost_per_month, 0, '.', ' ') ?>&nbsp;<span class="rub">Р</span>,
                    <?= $model->ad->getNumberOfRooms(); ?>,
                    <?= $model->ad->number_of_rooms_total_area; ?> м<sup>2</sup>
                </div>
            </a>
        </div>
    </div>
</div>