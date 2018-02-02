<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\components\widgets\AirDatepicker\AirDatepicker;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$form = ActiveForm::begin([
	'enableAjaxValidation'   => true,
	'enableClientValidation' => true,
]);
?>
	<div class="lk-set-formPass">
		<div class="wrapper-lk">
			<h2>Хотите сменить пароль?</h2>
			<p>На этой странице вы можете сменить ваш пароль. Пароль должен содержать не менее 6 символов и не может
				совпадать с
				логином.</p>
			<?php
			echo $form->field($model, 'password')->passwordInput([
				'placeholder' => 'Введите новый пароль',
				'onkeyup'     => 'User.Cabinet.toggleSaveButtonDisabled($(this))',
				'data'        => [
					'button-selector' => '.js-save-changed-password-button',
				],
			]);
			?>

			<div></div>

			<?php
			echo $form->field($model, 'password_repeat')->passwordInput([
				'placeholder' => 'Повторите пароль',
			]);
			?>
			<!--<i class="ok"></i>-->

			<div></div>

			<?=
			Html::submitInput('Сохранить', [
				'class' => 'btn btn--next h-mrg-t-15 disabled js-save-changed-password-button',
				'type'  => 'submit',
			]);
			?>
		</div>
	</div>
<?php ActiveForm::end(); ?>