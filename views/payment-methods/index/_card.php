<?php

use app\components\extend\Html;

/* @var $model app\models\PaymentMethods */
/* @var $model app\models\behaviors\payment_methods\PaymentMethodsCardBehavior */
?>

<?php
$validator = new \app\components\validators\CreditCardValidator();
$patterns = $validator->patterns;

$cardNumber = $model->getCardNumber(false);
$cardNumber = preg_replace('/[_ -]+/', '', $cardNumber);

$cardName = null;
foreach ($patterns as $index => $pattern) {
	$match = preg_match($pattern, $cardNumber);
	if ($match == true) {
		$cardName = $index;
		break;
	}
}
?>
<?php
switch ($cardName) {
	case $validator::MASTERCARD:
		echo '<img src="/images/master.png" alt="#">';
		break;
	case $validator::VISA:
		echo '<img src="/images/visa.png" alt="#">';
		break;
	default:
		echo '';
}
?>
<p><?= $model->getCardNumber(); ?></p>

    