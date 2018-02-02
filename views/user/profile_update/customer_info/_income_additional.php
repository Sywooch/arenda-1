<?php

use app\components\extend\Html;
use app\components\extend\DatePicker;
use app\models\UserCustomerInfo;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $model app\models\UserCustomerInfo */
/* @var $form yii\widgets\ActiveForm */
$dataIA = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_INCOME_ADDITIONAL) : UserCustomerInfo::DATA_INCOME_ADDITIONAL);
$dataIAS = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_INCOME_ADDITIONAL_SUM) : UserCustomerInfo::DATA_INCOME_ADDITIONAL_SUM);
?>

	<div data-order-nr="<?= (int)@$nameKey; ?>" data-compartment="<?= $dataIA; ?>"
	     class="js-user-profile-duplicate-fields js-user-profile-income-additional">
		<?= $this->render('_duplicate_header', ['nameKey' => @$nameKey]); ?>

		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_INCOME_ADDITIONAL) ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_INCOME_ADDITIONAL) ?></p>
				</div>
				<?= Html::activeTextInput($model, 'data' . $dataIA, [
					'class' => 'input--main lk-form--input-md',
					'value' => $model->getDataValue($dataIA),
				]); ?>
			</div>
		</div>

		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_INCOME_ADDITIONAL_SUM) ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_INCOME_ADDITIONAL_SUM) ?></p>
				</div>
				<?= Html::activeTextInput($model, 'data' . $dataIAS, [
					'class' => 'input--main lk-form--input-md',
					'value' => $model->getDataValue($dataIAS),
				]); ?>
			</div>
		</div>
	</div>

<?php
$data = $model->getDataValue(UserCustomerInfo::DATA_INCOME_ADDITIONAL, true);
if (!isset($nameKey) && is_array($data) && count($data) > 0) {
	foreach ($data as $key => $value) {
		if ($key == 1) {
			continue;
		}
		echo $this->render('_income_additional', [
			'model'   => $model,
			'form'    => $form,
			'nameKey' => $key,
		]);
	}
}
?>