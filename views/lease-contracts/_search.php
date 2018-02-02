<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\LeaseContractsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lease-contracts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'real_estate_id') ?>

    <?= $form->field($model, 'price_per_month') ?>

    <?= $form->field($model, 'payment_date') ?>

    <?= $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'date_begin') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
