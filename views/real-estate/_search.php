<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\RealEstateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="real-estate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'street') ?>

    <?= $form->field($model, 'total_area') ?>

    <?php // echo $form->field($model, 'corps') ?>

    <?php // echo $form->field($model, 'flat') ?>

    <?php // echo $form->field($model, 'metro_id') ?>

    <?php // echo $form->field($model, 'cover_image') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
