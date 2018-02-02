<?php

use app\components\extend\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\AirDatepicker\AirDatepicker;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php
    $form = ActiveForm::begin([
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
    ]);
    ?>

    <?= $form->field($model, 'serial_nr')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'issued_by')->textInput(['maxlength' => true]) ?>
    <div class="form-group field-userpassport-issued_date">
        <label class="control-label" for="userpassport-issued_date"><?= Html::activeLabel($model, 'issued_date') ?></label>
        <?php
        echo AirDatepicker::widget([
            'model'       => $model,
            'attribute'   => 'issued_date',
            'options'     => [
                'class' => 'input',
                'value' => $model->getDate('issued_date', 'd.m.Y'),
            ],
        ]);
        ?>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'division_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'place_of_birth')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'place_of_residence')->textarea(['maxlength' => true]) ?>
    <style>
        #userpassport-verify label{
            display: block;
        }
    </style>
    <?= $form->field($model, 'verify')->radioList(\app\models\UserPassport::getVerfiyLabels(false)); ?>
    <div class="form-group">
        <label class="control-label">Скан паспорт</label>
        <div><?= Html::a(Html::img($model->getScanUrl(),['width'=>'100%']),$model->getScanUrl(),['target'=>'_blank']); ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Обновить данны верификация', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
