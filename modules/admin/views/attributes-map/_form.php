<?php

use app\components\extend\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AttributesMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attributes-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'hint')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'input_type')->textInput() ?>

    <?= $form->field($model, 'purpose')->textInput() ?>

    <?= $form->field($model, 'parent')->textInput() ?>

    <?= $form->field($model, 'before')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'after')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
