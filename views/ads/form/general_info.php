<?php
use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\Ads;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;
use yii\helpers\ArrayHelper;

?>

<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'title'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form--inline">
			<?= $form->field($model, 'title')->textInput([
				'class' => 'input--main lk-form--input-md',
			])->hint(false);
			?>
		</div>
		<div class="lk-form--inline">
			<p class="lk-form--f-cursive">
				<?= $model->getAttributeHint('title'); ?>
			</p>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'description'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<?= $form->field($model, 'description')->textarea([
			'class' => 'textarea textarea--full',
			'cols'  => 30,
			'rows'  => 10,
		])->hint(false);
		?>
		<p class="lk-form--f-cursive">
			<?= $model->getAttributeHint('description'); ?>
		</p>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'house_type'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
        <?php
        $model->house_type = 1;
        ?>
		<div class="Half_btn h4 Half_btn--big">
			<div class="Half_btn_con">
				<label for="half_check1" class="Half_btn__item<?= ($model->house_type == 1) ? ' active' : ''; ?>">
					Жилье целиком
				</label>
				<label for="half_check2" class="Half_btn__item<?= ($model->house_type == 2) ? ' active' : ''; ?>">
					Комната
				</label>
				<label for="half_check3" class="Half_btn__item<?= ($model->house_type == 3) ? ' active' : ''; ?>">
					Общая комната
				</label>
			</div>
			<i></i>
			<div class="Half_btn__hide">
				<?php echo Html::activeRadio($model, 'house_type', ['id' => 'half_check1', 'value' => 1, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'house_type', ['id' => 'half_check2', 'value' => 2, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'house_type', ['id' => 'half_check3', 'value' => 3, 'uncheck' => null]); ?>
			</div>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'accommodation_type'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="Check_fam h4 Check_fam--col Check_fam--cir">
			<?= Html::error($model, 'accommodation_type', ['tag' => 'p', 'class' => 'help-block help-block-error']) ?>
			<?php
			$accoTypes = Ads::getAccommodationTypeLabels();
			$accoTypesChunkSize = ceil(count($accoTypes) / 2);
			$accoChunks = array_chunk($accoTypes, $accoTypesChunkSize, true);
			?>
			<?php foreach ($accoChunks as $chunkIndex => $accoChunk): ?>
				<ol>
					<?= $form->field($model, 'accommodation_type')->error(false)->radioList($accoChunk, [
						'unselect' => null,
						'item'     => function ($index, $label, $name, $checked, $value) use ($chunkIndex) {

							$contents = [];

							$contents[] = Html::beginTag('li');

							$id = $name . '_' . $chunkIndex . '_' . $index;
							
							if ($chunkIndex === 0 && $index === 0) {
							    $checked = 'checked';
                            }
							
							$contents[] = Html::radio($name, $checked, [
                                'id'    => $id,
                                'value' => $value,
                            ]);
							$contents[] = Html::label(Html::tag('i', '', ['class' => 'Check_fam__view']) . $label, $id);

							$contents[] = Html::endTag('li');

							return implode("\n", $contents);
						},
					]) ?>
				</ol>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'number_of_rooms'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<?= $form->field($model, 'number_of_rooms')->widget(CustomDropdown::classname(), [
			'containerOptions' => [
				'class' => 'selector lk-form--select-m selector-color--m js-selector',
			],
			'items'            => array_combine(range(1, 5), range(1, 5)),
		]);
		?>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'number_of_rooms_total_area'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form--inline">
			<?= $form->field($model, 'number_of_rooms_total_area')->textInput([
				'class' => 'input--main lk-form--input-sm js-num-input-validate',
			])->hint(false);
			?>
		</div>
		<div class="lk-form--inline">
			<p class="lk-form--f-">м2</p>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'number_of_rooms_living_area'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form--inline">
			<?= $form->field($model, 'number_of_rooms_living_area')->textInput([
				'class' => 'input--main lk-form--input-sm js-num-input-validate',
			])->hint(false);
			?>
		</div>
		<div class="lk-form--inline">
			<p class="lk-form--f-">м2</p>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'number_of_bedrooms'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<?= $form->field($model, 'number_of_bedrooms')->widget(CustomDropdown::classname(), [
			'containerOptions' => [
				'class' => 'selector lk-form--select-m selector-color--m js-selector',
			],
			'items'            => array_combine(range(1, 5), range(1, 5)),
		]);
		?>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'separate_bathroom'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="Half_btn h4 Half_btn--big">
			<div class="Half_btn_con">
				<label for="h_cc0" class="Half_btn__item<?= ($model->separate_bathroom == 0) ? ' active' : ''; ?>">
					Нет
				</label>
				<label for="h_cc1" class="Half_btn__item<?= ($model->separate_bathroom == 1) ? ' active' : ''; ?>">
					1
				</label>
				<label for="h_cc2" class="Half_btn__item<?= ($model->separate_bathroom == 2) ? ' active' : ''; ?>">
					2
				</label>
				<label for="h_cc3" class="Half_btn__item<?= ($model->separate_bathroom == 3) ? ' active' : ''; ?>">
					3
				</label>
				<label for="h_cc4" class="Half_btn__item<?= ($model->separate_bathroom == 4) ? ' active' : ''; ?>">
					4
				</label>
			</div>
			<i></i>
			<div class="Half_btn__hide">
				<?php echo Html::activeRadio($model, 'separate_bathroom', ['id' => 'h_cc0', 'value' => 0, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'separate_bathroom', ['id' => 'h_cc1', 'value' => 1, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'separate_bathroom', ['id' => 'h_cc2', 'value' => 2, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'separate_bathroom', ['id' => 'h_cc3', 'value' => 3, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'separate_bathroom', ['id' => 'h_cc4', 'value' => 4, 'uncheck' => null]); ?>
			</div>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'combined_bathroom'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="Half_btn h4 Half_btn--big">
			<div class="Half_btn_con">
				<label for="h_cd0" class="Half_btn__item<?= ($model->combined_bathroom == 0) ? ' active' : ''; ?>">
					Нет
				</label>
				<label for="h_cd1" class="Half_btn__item<?= ($model->combined_bathroom == 1) ? ' active' : ''; ?>">
					1
				</label>
				<label for="h_cd2" class="Half_btn__item<?= ($model->combined_bathroom == 2) ? ' active' : ''; ?>">
					2
				</label>
				<label for="h_cd3" class="Half_btn__item<?= ($model->combined_bathroom == 3) ? ' active' : ''; ?>">
					3
				</label>
				<label for="h_cd4" class="Half_btn__item<?= ($model->combined_bathroom == 4) ? ' active' : ''; ?>">
					4
				</label>
			</div>
			<i></i>
			<div class="Half_btn__hide">
				<?php echo Html::activeRadio($model, 'combined_bathroom', ['id' => 'h_cd0', 'value' => 0, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'combined_bathroom', ['id' => 'h_cd1', 'value' => 1, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'combined_bathroom', ['id' => 'h_cd2', 'value' => 2, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'combined_bathroom', ['id' => 'h_cd3', 'value' => 3, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'combined_bathroom', ['id' => 'h_cd4', 'value' => 4, 'uncheck' => null]); ?>
			</div>
		</div>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'condition'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<?= $form->field($model, 'condition')->widget(CustomDropdown::classname(), [
			'containerOptions' => [
				'class' => 'selector lk-form--select-md selector-color--m js-selector',
			],
			'items'            => Ads::getConditionTypeLabels(),
		]);
		?>
	</div>
</div>