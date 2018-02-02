<?php
use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\LeaseContracts;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;
use yii\helpers\ArrayHelper;

?>

<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-form--p-c">
			<?= Html::activeLabel($model, 'facilities2'); ?>
		</p>
		<p class="lk-form--p-sub lk-form--f-cursive">
			Необязательно
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="Check_fam h4 Check_fam--col Check_fam--sq">
			<?= Html::error($model, 'facilities2', ['tag' => 'p', 'class' => 'help-block help-block-error']) ?>
			<?php
			$facilitiesTypes = LeaseContracts::getFacilities2Labels();
			$facilitiesTypesChunkSize = ceil(count($facilitiesTypes) / 2);
			$facilitiesChunks = array_chunk($facilitiesTypes, $facilitiesTypesChunkSize, true);
			?>
			<?php foreach ($facilitiesChunks as $chunkIndex => $facilitiesChunk): ?>
				<ol>
					<?= $form->field($model, 'facilities')->error(false)->checkboxList($facilitiesChunk, [
						'unselect' => null,
						'item' => function ($index, $label, $name, $checked, $value) use ($chunkIndex) {

							$contents = [];

							$contents[] = Html::beginTag('li');

							$id = $name . '2_' . $chunkIndex . '_' . $index;
							$contents[] = Html::checkbox($name, $checked, [
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
			<?= Html::activeLabel($model, 'facilities'); ?>
		</p>
		<p class="lk-form--p-sub lk-form--f-cursive">
			Необязательно
		</p>
	</div>
	<div class="lk-form__col-r">
		<div class="Check_fam h4 Check_fam--col Check_fam--sq">
			<?= Html::error($model, 'facilities', ['tag' => 'p', 'class' => 'help-block help-block-error']) ?>
			<?php
			$facilitiesTypes = LeaseContracts::getFacilitiesLabels();
			$facilitiesTypesChunkSize = ceil(count($facilitiesTypes) / 2);
			$facilitiesChunks = array_chunk($facilitiesTypes, $facilitiesTypesChunkSize, true);
			?>
			<?php foreach ($facilitiesChunks as $chunkIndex => $facilitiesChunk): ?>
				<ol>
					<?= $form->field($model, 'facilities')->error(false)->checkboxList($facilitiesChunk, [
						'unselect' => null,
						'item' => function ($index, $label, $name, $checked, $value) use ($chunkIndex) {

							$contents = [];

							$contents[] = Html::beginTag('li');

							$id = $name . '_' . $chunkIndex . '_' . $index;
							$contents[] = Html::checkbox($name, $checked, [
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
			<?= Html::activeLabel($model, 'facilities_other'); ?>
		</p>
	</div>
	<div class="lk-form__col-r">
		<?= $form->field($model, 'facilities_other')->textarea([
			'class' => 'textarea textarea--full',
			'cols'  => 30,
			'rows'  => 10,
		])->hint(false);
		?>
	</div>
</div>