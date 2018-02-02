<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ApplicationRoommates */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,
            'options' => [
                'class' => 'js-applications-roommsmates-form'
            ]
        ]);
?>

<?= $form->field($model, 'id')->hiddenInput(['maxlength' => true, 'name' => 'id'])->label(''); ?>

<?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'name' => 'first_name']); ?>

<?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'name' => 'last_name']); ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true, 'name' => 'email']); ?>

<hr/>

<?=
Html::a('<i class="glyphicon glyphicon-floppy-disk"></i>', '#', [
    'title' => 'Сохранить',
    'data-loading-text' => 'Загрузка...',
    'class' => 'btn btn-primary',
    'onclick' => 'ApplicationRoommsmates.save($(this));return false;'
]);
?>

<?php ActiveForm::end(); ?>
