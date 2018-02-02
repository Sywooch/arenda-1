<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\AdsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'real_estate_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'house_type') ?>

    <?php // echo $form->field($model, 'accommodation_type') ?>

    <?php // echo $form->field($model, 'number_of_bedrooms') ?>

    <?php // echo $form->field($model, 'separate_bathroom') ?>

    <?php // echo $form->field($model, 'combined_bathroom') ?>

    <?php // echo $form->field($model, 'house_floors') ?>

    <?php // echo $form->field($model, 'location_floor') ?>

    <?php // echo $form->field($model, 'building_type') ?>

    <?php // echo $form->field($model, 'number_of_rooms') ?>

    <?php // echo $form->field($model, 'condition') ?>

    <?php // echo $form->field($model, 'place_add_to') ?>

    <?php // echo $form->field($model, 'watch_statistics') ?>

    <?php // echo $form->field($model, 'rent_cost_per_month') ?>

    <?php // echo $form->field($model, 'rent_term') ?>

    <?php // echo $form->field($model, 'rent_available_date') ?>

    <?php // echo $form->field($model, 'rent_pledge') ?>

    <?php // echo $form->field($model, 'check_credit_reports') ?>

    <?php // echo $form->field($model, 'check_biographical_information') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
