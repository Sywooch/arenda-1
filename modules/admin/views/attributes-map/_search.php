<?php

use app\components\extend\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\AttributesMapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attributes-map-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'label') ?>

    <?= $form->field($model, 'hint') ?>

    <?= $form->field($model, 'input_type') ?>

    <?= $form->field($model, 'purpose') ?>

    <?php // echo $form->field($model, 'parent') ?>

    <?php // echo $form->field($model, 'before') ?>

    <?php // echo $form->field($model, 'after') ?>


    <?php // echo $form->field($model, 'position') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
