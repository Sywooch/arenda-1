<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\models\LeaseContracts;

?>
<div class="lk-form__wr">
	<div class="lk-form__title">
		<p>Водоснабжение</p>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'counter_water_hot'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form--inline">
				<?= $form->field($model, 'counter_water_hot')->textInput([
					'class' => 'input--main lk-form--input-sm js-num-input-validate',
				]);
				?>
			</div>
		</div>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'counter_water_cold'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form--inline">
				<?= $form->field($model, 'counter_water_cold')->textInput([
					'class' => 'input--main lk-form--input-sm js-num-input-validate',
				]);
				?>
			</div>
		</div>
	</div>
</div>
<div class="separator-l"></div>
<div class="lk-form__wr">
	<div class="lk-form__title">
		<p>Электроэнергия</p>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'counter_electric_t1'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form--inline">
				<?= $form->field($model, 'counter_electric_t1')->textInput([
					'class' => 'input--main lk-form--input-sm js-num-input-validate',
				]);
				?>
			</div>
		</div>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'counter_electric_t2'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form--inline">
				<?= $form->field($model, 'counter_electric_t2')->textInput([
					'class' => 'input--main lk-form--input-sm js-num-input-validate',
				]);
				?>
			</div>
		</div>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'counter_electric_t3'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form--inline">
				<?= $form->field($model, 'counter_electric_t3')->textInput([
					'class' => 'input--main lk-form--input-sm js-num-input-validate',
				]);
				?>
			</div>
		</div>
	</div>
</div>
<div class="separator-l"></div>
<div class="lk-form__wr">
	<div class="lk-form__title">
		<p>Дополнительные сведения</p>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">
				<?= Html::activeLabel($model, 'counter_additional'); ?>
			</p>
		</div>
		<div class="lk-form__col-r">
			<?= $form->field($model, 'counter_additional')->textarea([
				'class' => 'textarea textarea--full',
				'cols'  => 30,
				'rows'  => 10,
			]);
			?>
		</div>
	</div>
</div>
<div class="separator-l"></div>
<div class="submit-form-row--2">
	<div class="submit-form-row--2__link">
		<a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 3]) ?>" class="link link--prev-blue">
			Назад
		</a>
	</div>
	<div class="submit-form-row--2__btn">
		<?= Html::submitButton('Вперед', ['class' => 'btn btn--next']) ?>
	</div>
</div>
