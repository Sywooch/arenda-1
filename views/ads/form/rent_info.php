<?php
use app\components\extend\Html;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\models\Ads;

?>
	<style>.disabled{ background: #F4F4F4; }</style>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'rent_cost_per_month'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form--inline">
			<?= $form->field($model, 'rent_cost_per_month')->textInput([
				'class' => 'input--main lk-form--input-sm',
			])->hint(false);
			?>
		</div>
		<div class="lk-form--inline">
			<div class="icon icon--ruble"></div>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'rent_term'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form--inline">
			<?php
			$rentTermOptions = [
				'class' => 'input--main lk-form--input-sm js-num-input-validate',
			];

			if ($model->rent_term_undefined) {
				Html::addCssClass($rentTermOptions, 'disabled');
				$rentTermOptions['readonly'] = 1;
			}

			echo $form->field($model, 'rent_term')->textInput($rentTermOptions)->hint(false);
			?>
		</div>
		<div class="lk-form--inline">
			<p class="lk-form--f-">мес.</p>
		</div>
		<div class="checkbox h-mrg-t-20">
			<?= $form->field($model, 'rent_term_undefined')->checkbox([
				'template' => "{error}{input}{label}",
			]); ?>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'rent_available'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<ul class="checkbox-row">
			<?= $form->field($model, 'rent_available')->radioList(Ads::getRentAvailableLabels(), [
				'item' => function ($index, $label, $name, $checked, $value) {

					$contents = [];

					$contents[] = Html::beginTag('li');
					$contents[] = Html::beginTag('div', ['class' => 'radiobtn']);

					$id = $name . '_' . $index;
					$contents[] = Html::radio($name, $checked, [
						'id'    => $id,
						'value' => $value,
						'class' => ($value == Ads::RENT_AVAILABLE_AVAILABLE_DATE) ? 'Exact-date--btn Exact-date' : '',
					]);
					$contents[] = Html::label(Html::tag('i', '', ['class' => 'Check_fam__view']) . $label, $id);

					$contents[] = Html::endTag('div');
					$contents[] = Html::endTag('li');

					return implode("\n", $contents);
				},
			]) ?>
		</ul>
		<?= $form->field($model, 'rent_available_date')->widget(AirDatepicker::classname(), [
			'containerOptions' => [
				'class' => 'input--datepicker lk-form--datepicker-md js-datepicker Exact-date--in',
			],
			'options'          => [
				'class'       => 'input air-datepicker',
				'placeholder' => 'Выберете дату...',
				'value'       => $model->getDate('rent_available_date', 'd.m.Y'),
			],
		]);
		?>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'rent_pledge'); ?>
		</p>
		<p class="lk-form--p-sub lk-form--f-cursive">Необязательно</p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form--inline">
			<?= $form->field($model, 'rent_pledge')->textInput([
				'class' => 'input--main lk-form--input-sm',
			])->hint(false);
			?>
		</div>
		<div class="lk-form--inline">
			<div class="icon icon--ruble"></div>
		</div>
	</div>
</div>

<?php
$this->registerJs(<<<JS
    $("#ads-rent_term_undefined").change(function () {
        var term_undefined = $("#ads-rent_term_undefined").prop('checked');
        $("#ads-rent_term").attr('readonly', term_undefined);
        if (term_undefined) {
            $("#ads-rent_term").addClass('disabled');
            $("#ads-rent_term").val('');
        } else {
            $("#ads-rent_term").removeClass('disabled');
            $("#ads-rent_term").val(1);
        }
    });

    $("#ads-rent_cost_per_month").change(function () {
        $("#ads-rent_pledge").val($("#ads-rent_cost_per_month").val());
    });
JS
);

?>