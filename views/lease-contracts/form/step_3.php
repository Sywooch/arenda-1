<?php

use app\components\extend\Html;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\models\LeaseContracts;
use app\components\extend\Url;

extract($payment);

?>
<?= Html::activeHiddenInput($model, 'date_created') ?>
<div class="form-param-1">
	<div class="wpapper-con wrapper-con-2 js-tabs">
		<div class="lk_carts_and_accounts lk_carts_and_accounts--modif-in-content">
			<?= $form->field($model, 'payment_method_id')->hiddenInput([
				'class' => 'contract-payment_method_id',
			])->label(false);
			?>
			<?= $this->render('//payment-methods/index_inner', [
				'dataProviderCards'    => $dataProviderCards,
				'dataProviderAccounts' => $dataProviderAccounts,
				'selectedMethodId'     => $model->payment_method_id,
			]); ?>
		</div>
	</div>
</div>
<div class="separator-l"></div>
<div class="submit-form-row--2">
	<div class="submit-form-row--2__link">
		<a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 2]) ?>" class="link link--prev-blue">
			Назад
		</a>
	</div>
	<div class="submit-form-row--2__btn">
		<?= Html::submitButton('Вперед', ['class' => 'btn btn--next']) ?>
	</div>
</div>

