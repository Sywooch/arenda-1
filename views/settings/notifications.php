<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$form = ActiveForm::begin([
	'enableAjaxValidation'   => false,
	'enableClientValidation' => false,
]);
?>
	<div class="lk-set-form lk-form">
		<h2 class="lk-set-h">Заявки и скрининг</h2>

		<div class="lk-set-form__check">
			<?= Html::activeCheckbox($user, User::DATA_NOTE_NEW_APPLICATION, ['label' => false]); ?>
			<label for="lk-set-1">
				<h3><?= $user->getDataLabels(User::DATA_NOTE_NEW_APPLICATION); ?></h3>
				<p><?= $user->getDataHints(User::DATA_NOTE_NEW_APPLICATION) ?></p>
			</label>
		</div>

		<div class="lk-set-form__check">
			<?= Html::activeCheckbox($user, User::DATA_NOTE_CHECK_PERSONAL_DATA, ['label' => false]); ?>
			<label for="lk-set-1">
				<h3><?= $user->getDataLabels(User::DATA_NOTE_CHECK_PERSONAL_DATA); ?></h3>
				<p><?= $user->getDataHints(User::DATA_NOTE_CHECK_PERSONAL_DATA) ?></p>
			</label>
		</div>

		<h2 class="lk-set-h">Платежи и договоры аренды</h2>

		<div class="lk-set-form__check">
			<?= Html::activeCheckbox($user, User::DATA_NOTE_STATUS_OF_COSTUMER_CHECK, ['label' => false]); ?>
			<label for="lk-set-1">
				<h3><?= $user->getDataLabels(User::DATA_NOTE_STATUS_OF_COSTUMER_CHECK); ?></h3>
				<p><?= $user->getDataHints(User::DATA_NOTE_STATUS_OF_COSTUMER_CHECK) ?></p>
			</label>
		</div>

		<div class="lk-set-form__check">
			<?= Html::activeCheckbox($user, User::DATA_NOTE_WHEN_CUSTOMER_PAY, ['label' => false]); ?>
			<label for="lk-set-1">
				<h3><?= $user->getDataLabels(User::DATA_NOTE_WHEN_CUSTOMER_PAY); ?></h3>
				<p><?= $user->getDataHints(User::DATA_NOTE_WHEN_CUSTOMER_PAY) ?></p>
			</label>
		</div>

		<div class="lk-set-form__check">
			<?= Html::activeCheckbox($user, User::DATA_NOTE_BEFORE_LEASE_ENDS, ['label' => false]); ?>
			<label for="lk-set-1">
				<h3><?= $user->getDataLabels(User::DATA_NOTE_BEFORE_LEASE_ENDS); ?></h3>
				<p><?= $user->getDataHints(User::DATA_NOTE_BEFORE_LEASE_ENDS) ?></p>
			</label>
		</div>

		<?=
		Html::submitInput('Сохранить', [
			'class' => 'btn btn--next h-mrg-t-15',
			'type'  => 'submit',
		]);
		?>

	</div>
<?php ActiveForm::end(); ?>