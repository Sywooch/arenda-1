<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ExternalPlatforms as Platform;

/* @var $this yii\web\View */
/* @var $model app\models\ExternalPlatforms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="external-platforms-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'service_id')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?=
            $this->render('_form/_template', [
                'model' => $model,
                'form' => $form,
            ]);
            ?>
        </div>
    </div>


    <?= $form->field($model, Platform::PARAMS_PRICE)->textInput()->label($model->getAttributeLabel(Platform::PARAMS_PRICE)) ?>

    <?= $form->field($model, 'status')->radioList($model->getStatusLabels()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
