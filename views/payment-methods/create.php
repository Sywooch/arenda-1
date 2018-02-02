<?php

use app\components\extend\Html;
use app\models\PaymentMethods;

?>
<div class="box-modal modal">
	<div class="modal__close box-modal_close arcticmodal-close"></div>
	<div class="modal__wr">
		<?php
		switch ($model->type) {
			case PaymentMethods::TYPE_CARD:
				echo $this->render('_form/_card_account', [
					'model' => $model,
				]);
				break;
			case PaymentMethods::TYPE_BANK_ACCOUNT:
				echo $this->render('_form/_bank_account', [
					'model' => $model,
				]);
				break;
		}
		?>
	</div>
</div>
