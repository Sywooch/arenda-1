<?php

use app\components\extend\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Сброс пароля';
?>

<?= Html::tag('h1', 'Сброс пароля'); ?>

<?=
Html::tag('p', 'Пожалуйста, заполните вашу электронную почту. Ссылка для сброса пароля будет отправлена туда', [
    'class' => 'text-info'
]);
?>


<?php
$form = ActiveForm::begin([
            'id' => 'request-password-reset-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => false
        ]);
?>

<?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
