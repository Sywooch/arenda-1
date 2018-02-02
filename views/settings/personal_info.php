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
	'enableAjaxValidation'   => false,
	'enableClientValidation' => false,
]);
?>
	<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20">
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'last_name') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'last_name') ?></p>
				</div>
				<?= $form->field($user, 'last_name')->textInput(['class' => 'input--main lk-form--input-md'])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'first_name') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'first_name') ?></p>
				</div>
				<?= $form->field($user, 'first_name')->textInput(['class' => 'input--main lk-form--input-md'])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'middle_name') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'middle_name') ?></p>
				</div>
				<?= $form->field($user, 'middle_name')->textInput(['class' => 'input--main lk-form--input-md'])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'email') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'email') ?></p>
				</div>
				<?= $form->field($user, 'email')->textInput(['class' => 'input--main lk-form--input-md'])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'phone') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'phone') ?></p>
				</div>
				<?= $form->field($user, 'phone')->textInput(['class' => 'input--main lk-form--input-md'])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'date_of_birth') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'date_of_birth') ?></p>
				</div>
				<?= $form->field($user, 'date_of_birth')->widget(AirDatepicker::classname(), [
					'options' => [
						'class'       => 'input air-datepicker',
						'placeholder' => 'Выберите дату...',
						'value'       => $user->getDate('date_of_birth', 'd.m.Y'),
					],
				]);
				?>
			</div>
		</div>

		<h2 id="passport" class="lk-set-h h-mrg-t-50">Паспортные данные</h2>

		<?= $this->render('personal_info_passport', [
			'form'     => $form,
			'passport' => $passport,
		]) ?>

		<div class="lk-form__row h-mrg-b-0">
			<div class="lk-form__col-r">
				<?=
				Html::submitInput('Сохранить', [
					'class' => 'btn btn--next h-mrg-t-15',
					'type'  => 'submit',
				]);
				?>
			</div>
		</div>

	</div>
<?php ActiveForm::end(); ?>