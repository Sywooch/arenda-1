<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\models\Ads;

/* @var $model app\models\Ads */
/* @var $realEstate \app\models\RealEstate */

$estate = $model->estate;
?>

<div class="lord_prod">
    <a href="<?= Url::to(['/ads/view', 'id' => $model->primaryKey]) ?>">
        <?php
        echo $model->cover->file->renderImage([
            'width'  => 200,
            'height' => 140,
        ]);
        ?>
    </a>
    <?php
    $imagesCount = $model->getImages()->count();
    if ($imagesCount > 0) {
        echo Html::tag('i', $imagesCount);
    }
    ?>
    <h4 class="h4">
        <span><?= $model->title ?></span>
    </h4>
    <ol class="lord_prod-par">
        <li><?= $model->getNumberOfRooms(); ?></li>
        <li><?= $model->getRentTerm(); ?></li>
    </ol>
    <ol class="lord_prod-par">
        <li><?= $model->location_floor ?> этаж из <?= $model->house_floors ?></li>
        <li><?= ($model->hasFacility(Ads::FACILITIES_BALCONY)) ? 'есть балкон' : '&nbsp;'; ?></li>
    </ol>
    <ol class="lord_prod-par">
        <li><?= $model->number_of_rooms_total_area; ?> м<sup>2</sup></li>
        <li><?= $model->number_of_rooms_living_area; ?> м<sup>2</sup></li>
    </ol>
    <ol class="lord_prod-par">
        <li><?= $model->getRentCostPerMonth() ?></li>
        <li><?= $model->getRentCostPerYear() ?></li>
    </ol>
    <ol class="lord_prod-b">
        <?=
        Html::a('Посмотреть полностью', ['/ads/view', 'id' => $model->primaryKey], [
            'class' => 'btn btn-w',
            'data' => [
                'pjax' => 0
            ]
        ]);
        ?>
        <?php $currentUser = Yii::$app->user->identity; ?>
        <?php if (isset($currentUser->id) && ($model->estate->user_id == $currentUser->id)): ?>
            <?= Html::a('Создать договор', ['/lease-contracts/create', 'eId' => $estate->primaryKey], [
                'class' => 'btn btn-bl',
                'data'  => [
                    'pjax' => 0,
                ],
            ]);
            ?>
        <?php endif ?>

    </ol>
</div>
