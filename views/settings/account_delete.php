<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$form = ActiveForm::begin([
	'enableAjaxValidation'   => false,
	'enableClientValidation' => false,
]);
?>
	<div class="lk-set-formPass">
		<div class="wrapper-lk">
			<h2>Вы уверены?</h2>
			<p>
				Если у вас возникли проблемы при использовании Арендатики, не торопитесь удалять аккаунт, <a href="<?= Url::to(['/contacts']); ?>">свяжитесь с нами</a>, мы постараемся вам помочь.
			</p>
			<?=
			Html::activeHiddenInput($user, 'deleteAccount', [
				'value' => 1,
			])
			?>
			<?php
			/*echo Html::activeTextarea($user, 'passwordConfirmation', [
				'placeholder' => 'Скажите, что вам могли бы сделать лучше?',
			]);*/
			?>
			<div class="lk-set-formPass--holder">
				<?php
				echo $form->field($user, 'passwordConfirmation')->passwordInput([
					'class'       => 'rfield',
					'placeholder' => 'Ваш пароль для подтверждения',
				]);
				?>
				<!--<label for="sdfa">Ваш пароль для подтверждения<span>*</span></label>-->
			</div>
			<?=
			Html::submitInput('Удалить аккаунт', [
				'class'   => 'btn btn-gr',
				'type'    => 'submit',
				'onclick' => 'User.Cabinet.deleteAccount($(this));return false;',
			]);
			?>
		</div>
	</div>
<?php ActiveForm::end(); ?>