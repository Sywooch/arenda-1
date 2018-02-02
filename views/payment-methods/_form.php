<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\PaymentMethods;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentMethods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-methods-form">

    <?php
    $form = ActiveForm::begin([
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
    ]);
    ?>
    <?php
    switch ($model->type) {
        case PaymentMethods::TYPE_CARD:
            echo $this->render('_form/_card_account', [
                'form' => $form,
                'model' => $model
            ]);
            break;
        default :
            echo $this->render('_form/_bank_account', [
                'form' => $form,
                'model' => $model
            ]);
            break;
    }
    ?>
    <?= $form->field($model, 'status')->dropDownList($model->getStatusLabels()) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
