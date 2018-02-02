<?php

use app\components\extend\Html;
use app\components\extend\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'reset password';
$this->params['pageHeader'] = Html::tag('h1', 'reset password');
?>
<?=
Html::tag('p', 'please choose your new password', [
    'class' => 'text-info'
]);
?>
<div class="row">
    <div class="col-lg-5">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'reset-password-form',
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => false
        ]);
        ?>
        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>
        <div class="form-group">
            <?= Html::submitButton('save', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
