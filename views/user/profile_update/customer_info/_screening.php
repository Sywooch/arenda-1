<?php

use app\components\extend\Html;
use app\models\UserCustomerInfo;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $model app\models\UserCustomerInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lk-form__row">
	<p><?= $model->getDataLabels(UserCustomerInfo::DATA_SCREENING_WERE_INSOLVENT); ?><span>*</span></p>
	<div class="lk-edit__varBtn">
		<input name="Банкрот" id="lkev1" type="radio" value="1" <?= ($model->getDataValue(UserCustomerInfo::DATA_SCREENING_WERE_INSOLVENT) == 1) ? 'checked' : '' ?>>
		<label for="lkev1">ДА</label>
		<input name="Банкрот" id="lkev2" type="radio" value="0" <?= ($model->getDataValue(UserCustomerInfo::DATA_SCREENING_WERE_INSOLVENT) == 0) ? 'checked' : '' ?>>
		<label for="lkev2">Нет</label>
		<?= Html::activeHiddenInput($model, 'data' . UserCustomerInfo::DATA_SCREENING_WERE_INSOLVENT, [
			'class' => 'input-checkbox-value-holder',
		]); ?>
	</div>
	<p><?= $model->getDataLabels(UserCustomerInfo::DATA_SCREENING_WERE_CONFLICT); ?><span>*</span></p>
	<div class="lk-edit__varBtn">
		<input name="Конфликты" id="lkev3" type="radio" value="1" <?= ($model->getDataValue(UserCustomerInfo::DATA_SCREENING_WERE_CONFLICT) == 1) ? 'checked' : '' ?>>
		<label for="lkev3">ДА</label>
		<input name="Конфликты" id="lkev4" type="radio" value="0" <?= ($model->getDataValue(UserCustomerInfo::DATA_SCREENING_WERE_CONFLICT) == 0) ? 'checked' : '' ?>>
		<label for="lkev4">Нет</label>
		<?= Html::activeTextarea($model, 'data' . UserCustomerInfo::DATA_SCREENING_WERE_CONFLICT_INFO); ?>

		<?= Html::activeHiddenInput($model, 'data' . UserCustomerInfo::DATA_SCREENING_WERE_CONFLICT, [
			'class' => 'input-checkbox-value-holder',
		]); ?>
	</div>
	<p><?= $model->getDataLabels(UserCustomerInfo::DATA_SCREENING_REFUSED_TO_PAY); ?><span>*</span></p>
	<div class="lk-edit__varBtn">
		<input name="Отказались" id="lkev5" type="radio" value="1" <?= ($model->getDataValue(UserCustomerInfo::DATA_SCREENING_REFUSED_TO_PAY) == 1) ? 'checked' : '' ?>>
		<label for="lkev5">ДА</label>
		<input name="Отказались" id="lkev6" type="radio" value="0" <?= ($model->getDataValue(UserCustomerInfo::DATA_SCREENING_REFUSED_TO_PAY) == 0) ? 'checked' : '' ?>>
		<label for="lkev6">Нет</label>

		<?= Html::activeHiddenInput($model, 'data' . UserCustomerInfo::DATA_SCREENING_REFUSED_TO_PAY, [
			'class' => 'input-checkbox-value-holder',
		]); ?>
	</div>
	<p><?= $model->getDataLabels(UserCustomerInfo::DATA_SCREENING_CONVICTED); ?><span>*</span></p>
	<div class="lk-edit__varBtn">
		<input name="Нарушения" id="lkev7" type="radio" value="1" <?= ($model->getDataValue(UserCustomerInfo::DATA_SCREENING_CONVICTED) == 1) ? 'checked' : '' ?>>
		<label for="lkev7">ДА</label>
		<input name="Нарушения" id="lkev8" type="radio" value="0" <?= ($model->getDataValue(UserCustomerInfo::DATA_SCREENING_CONVICTED) == 0) ? 'checked' : '' ?>>
		<label for="lkev8">Нет</label>

		<?= Html::activeHiddenInput($model, 'data' . UserCustomerInfo::DATA_SCREENING_CONVICTED, [
			'class' => 'input-checkbox-value-holder',
		]); ?>
	</div>
</div>

