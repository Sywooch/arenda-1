<?php

use app\components\extend\Html;
use app\models\UserCustomerInfo;
use app\components\widgets\AirDatepicker\AirDatepicker;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $model app\models\UserCustomerInfo */
/* @var $form yii\widgets\ActiveForm */


$dataEHJ = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_EMPL_HISTORY_JOB) : UserCustomerInfo::DATA_EMPL_HISTORY_JOB);
$dataEHP = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_EMPL_HISTORY_POST) : UserCustomerInfo::DATA_EMPL_HISTORY_POST);
$dataEHPB = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_EMPL_HISTORY_PERIOD_BGN) : UserCustomerInfo::DATA_EMPL_HISTORY_PERIOD_BGN);
$dataEHPE = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_EMPL_HISTORY_PERIOD_END) : UserCustomerInfo::DATA_EMPL_HISTORY_PERIOD_END);
$dataEHE = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_EMPL_HISTORY_EMPLOYER_INFO) : UserCustomerInfo::DATA_EMPL_HISTORY_EMPLOYER_INFO);
?>

	<div data-order-nr="<?= (int)@$nameKey; ?>" data-compartment="<?= $dataEHJ; ?>"
	     class="js-user-profile-duplicate-fields js-user-profile-employe-history">
		<?= $this->render('_duplicate_header', ['nameKey' => @$nameKey]); ?>

		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_EMPL_HISTORY_JOB) ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_EMPL_HISTORY_JOB) ?></p>
				</div>
				<?= Html::activeTextInput($model, 'data' . $dataEHJ, [
					'class' => 'input--main lk-form--input-md',
					'value' => $model->getDataValue($dataEHJ),
				]); ?>
			</div>
		</div>

		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_EMPL_HISTORY_POST) ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_EMPL_HISTORY_POST) ?></p>
				</div>
				<?= Html::activeTextInput($model, 'data' . $dataEHP, [
					'class' => 'input--main lk-form--input-md',
					'value' => $model->getDataValue($dataEHP),
				]); ?>
			</div>
		</div>

		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_EMPL_HISTORY_PERIOD_BGN) ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_EMPL_HISTORY_PERIOD_BGN) ?></p>
				</div>
				<div class="lk-form--inline">
					<div class="input--datepicker lk-form--datepicker-md js-datepicker is-active">
						<?php
						echo AirDatepicker::widget([
							'model'       => $model,
							'attribute'   => 'data' . $dataEHPB,
							'options'     => [
								'class' => 'input air-datepicker',
								'placeholder' => 'Выберете дату...',
								'value' => $model->getDataDate($dataEHPB),
							],
							'addonAppend' => '<div class="input--datepicker__icon"></div>',
						]);
						?>
					</div>
				</div>
				<div class="lk-form--inline">
					<div class="input--datepicker lk-form--datepicker-md js-datepicker is-active">
						<?php
						echo AirDatepicker::widget([
							'model'       => $model,
							'attribute'   => 'data' . $dataEHPE,
							'options'     => [
								'class' => 'input air-datepicker',
								'placeholder' => 'Выберете дату...',
								'value' => $model->getDataDate($dataEHPE),
							],
							'addonAppend' => '<div class="input--datepicker__icon"></div>',
						]);
						?>
					</div>
				</div>
			</div>
		</div>

		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_EMPL_HISTORY_EMPLOYER_INFO) ?></p>
				<p class="lk-form--f-cursive">Не обязательно</p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form--inline">
					<div class="lk-form__hidden-subt">
						<p class="lk-set-p"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_EMPL_HISTORY_EMPLOYER_INFO) ?></p>
					</div>
					<?= Html::activeTextInput($model, 'data' . $dataEHE, [
						'class' => 'input--main lk-edit--w',
						'value' => $model->getDataValue($dataEHE),
					]); ?>
				</div>
			</div>
		</div>

	</div>

<?php
$data = $model->getDataValue(UserCustomerInfo::DATA_EMPL_HISTORY_EMPLOYER_INFO, true);
if (!isset($nameKey) && is_array($data) && count($data) > 0) {
	foreach ($data as $key => $value) {
		if ($key == 1) {
			continue;
		}
		echo $this->render('_employe_history', [
			'model'   => $model,
			'form'    => $form,
			'nameKey' => $key,
		]);
	}
}
?>