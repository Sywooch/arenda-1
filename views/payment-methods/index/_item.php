<?php

use app\components\extend\Html;
use app\models\PaymentMethods;
use app\components\extend\Url;

/* @var $model app\models\PaymentMethods */
/* @var $model app\models\behaviors\payment_methods\PaymentMethodsCardBehavior */
/* @var $model app\models\behaviors\payment_methods\PaymentMethodsBankAccountBehavior */
?>

<div class="lk_carts_and_accounts--line<?= ($selectedMethodId == $model->id) ? ' _chosen-way' : '' ?>" data-payment-way-gr="base_group" data-payment-method-id="<?= $model->id ?>">
	<?php
	switch ($model->type) {
		case PaymentMethods::TYPE_CARD:
			echo $this->render('_card', [
				'model' => $model,
				'index' => $index,
			]);
			break;
		case PaymentMethods::TYPE_BANK_ACCOUNT:
			echo $this->render('_bank_account', [
				'model' => $model,
				'index' => $index,
			]);
			break;
	}
	?>
	<div class="lk_carts_and_accounts--btn" data-payment-way-choose-btn="">
		<?php if (Yii::$app->controller->id == 'payment-methods'): ?>
			<?php
			if ($model->type != PaymentMethods::TYPE_CARD) {
				Html::a('Редактировать', '#!', [
					'class' => 'btn btn-w js-modal-link-ajax',
					'title' => 'Редактировать',
					'data'  => [
						'href' => Url::to(['update', 'id' => $model->primaryKey]),
						'pjax' => 0,
					],
				]);
			}
			?>
			<?=
			Html::a('Удалить', '#!', [
				'class' => 'btn btn-gr js-modal-link-ajax',
				'title' => 'Удалить',
				'data'  => [
					'href' => Url::to(['delete', 'id' => $model->primaryKey]),
					'pjax' => 0,
				],
			]);
			?>
		<?php endif; ?>

		<?php if (Yii::$app->controller->id == 'lease-contracts'): ?>
			<div class="state-btn">
				<span class="state-btn__state state-btn__state--not-checked btn btn-w" style="display:<?= ($selectedMethodId == $model->id) ? 'none' : 'block' ?>">Выбрать</span>
				<span class="state-btn__state state-btn__state--checked btn btn-w" style="display:<?= ($selectedMethodId == $model->id) ? 'block' : 'none' ?>">Отменить</span>
			</div>
		<?php endif; ?>
	</div>
</div>