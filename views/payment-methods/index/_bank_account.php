<?php
use app\models\behaviors\payment_methods\PaymentMethodsBankAccountBehavior;

/* @var $model app\models\PaymentMethods */
/* @var $model app\models\behaviors\payment_methods\PaymentMethodsBankAccountBehavior */
?>

<p>
	<span>Лицевой счёт</span>
	<span>№<?= $model->getAccountNumber(); ?></span>

	<?php if (isset($model->data[PaymentMethodsBankAccountBehavior::BANK_NAME]) && $model->data[PaymentMethodsBankAccountBehavior::BANK_NAME] != ''): ?>
		<span><?= $model->getBankName(); ?></span>
	<?php endif; ?>
</p>