<?php

use app\models\Applications;
use app\models\Ads;
use app\components\extend\Html;
use app\components\extend\Url;

$this->registerJs(<<<JS
    $('.__app_view').on('click', function(e){       
        var href = $(this).data('href');
        
        window.location = href;
    });
JS
);

?>

<div class="lk-temp-apps-item __app_view" data-href="<?= Url::to(['/applications/view-by-ad', 'id' =>$model->id]); ?>">
    <div class="lk-temp-apps-item__top">
        <div class="lk-temp-apps-item__section_f">
            <div class="lk-temp-apps-item__image">
                <?php
                echo $model->cover->file->renderImage([
                    'width'  => 111,
                    'height' => 74,
                ]);
                ?>
            </div>
            <div class="lk-temp-apps-item__info">
                <div class="lk-temp-apps-item__name"><?= $model->estate->title; ?></div>
                <div class="lk-temp-apps-item__text">
                    <div class="lk-temp-apps-item__status <?= ($model->status == Ads::STATUS_ACTIVE) ? '_active' : '_disable'; ?>"></div>
                    <?= number_format($model->rent_cost_per_month, 0, '.', ' ') ?>&nbsp;<span class="rub">Р</span>,
                    <?= $model->getNumberOfRooms(); ?>,
                    <?= $model->number_of_rooms_total_area; ?> м<sup>2</sup>
                </div>
            </div>
        </div>
        <div class="lk-temp-apps-item__section">
            <div class="lk-temp-apps-item__t">
                <div class="lk-temp-apps-item__text_n">
                    Заявок: <b><?= $model->getApplicationsCount() ?></b>
                    <?php
                    $newApplications = $model->getNewApplicationsCount();
                    if ($newApplications > 0) {
                        echo Html::tag('div', $newApplications, ['class' => 'label-rect']);
                    }
                    ?>
                </div>
                <div class="lk-temp-apps-item__text">
                    За сегодня <?= $model->getApplicationsCountToday(); ?>,
                    за неделю <?= $model->getApplicationsCountWeek(); ?>
                </div>
            </div>
        </div>
    </div>
</div>