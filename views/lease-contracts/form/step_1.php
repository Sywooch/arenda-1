<?php

use app\components\extend\Html;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\models\LeaseContracts;
use app\models\User;

?>
<div class="lk-form__wr">
	<div class="lk-form__title">
		<p>Объект и сроки</p>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'real_estate_id'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<?php $customer = Yii::$app->user->identity;
			if($customer->hasRole([User::ROLE_CUSTOMER])){
				$userid = $model->user_id;
			}else{
				$userid = Yii::$app->user->id;
			}?>
			<?= $form->field($model, 'real_estate_id')->widget(CustomDropdown::classname(), [
				'items' => \yii\helpers\ArrayHelper::map(\app\models\RealEstate::find()->where(['user_id' => $userid])->all(), 'id', 'title'),
			]);
			?>
		</div>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'date_begin'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<?= $form->field($model, 'date_begin')->widget(AirDatepicker::classname(), [
				'options' => [
					'class'       => 'input air-datepicker',
					'placeholder' => 'Выберете дату...',
					'value'       => $model->getDate('date_begin', 'd.m.Y'),
				],
			]);
			?>
		</div>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'lease_term'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form--inline">
				<?= $form->field($model, 'lease_term')->widget(CustomDropdown::classname(), [
					'items' => LeaseContracts::getLeaseTermLabels(),
				]);
				?>
			</div>
			<div class="lk-form--inline">
				<p class="lk-form--f-cursive">Предусмотрен максимальный<br> срок 11 месяцев</p>
			</div>
		</div>
	</div>
</div>
<div class="separator-l"></div>
<div class="lk-form__wr">
	<div class="lk-form__title">
		<p>Условия</p>
	</div>
	<?= $this->render('details_info', [
		'form'  => $form,
		'model' => $model,
	]); ?>
</div>

<div class="separator-l"></div>
<div class="submit-form-row submit-form-row--form-l">
	<?= Html::submitButton('Вперед', ['class' => 'btn btn--next']) ?>
</div>


