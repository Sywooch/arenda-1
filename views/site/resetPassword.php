<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Восстановление пароля';
$this->params['pageHeader'] = Html::tag('h1', 'reset password');
?>
<div class="wrapper-lk" style="padding-top: 20px;">
	<div class="lk-backTitle">
		<h1 class="lk-tit"><?= $this->title ?></h1>
	</div>
	<section class="lk-temp lk-temp-trans lk-temp cf">
		<?php
		$form = ActiveForm::begin([
			'id'                     => 'reset-password-form',
			'enableClientValidation' => true,
			'enableAjaxValidation'   => false,
		]);
		?>
		<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-set-p required"><?= Html::activeLabel($model, 'password') ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-set-p required"><?= Html::activeLabel($model, 'password') ?></p>
					</div>
					<?= $form->field($model, 'password')->passwordInput(['class' => 'input--main lk-form--input-md']) ?>
				</div>
			</div>
		</div>
		<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-set-p required"><?= Html::activeLabel($model, 'password_repeat') ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-set-p required"><?= Html::activeLabel($model, 'password_repeat') ?></p>
					</div>
					<?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'input--main lk-form--input-md']) ?>
				</div>
			</div>
		</div>
		<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
			<div class="lk-form__row">
				<div class="lk-form__col-r">
					<?= Html::submitButton('Сохранить', ['class' => 'btn btn--next']) ?>
				</div>
			</div>
		</div>

		<?php ActiveForm::end(); ?>
	</section>
</div>
