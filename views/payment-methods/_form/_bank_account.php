<?php
use app\components\extend\Url;
use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\behaviors\payment_methods\PaymentMethodsBankAccountBehavior;

$actionUrl = ($model->isNewRecord) ? Url::to(['create', 'type' => $model->type]) : Url::to(['update', 'id' => $model->id]);
$modalTitle = ($model->isNewRecord) ? 'Добавление счета' : 'Редактировать данные счета';
$actionButtonLabel = ($model->isNewRecord) ? 'Добавить' : 'Сохранить изменения';
$cancelButtonLabel = ($model->isNewRecord) ? 'Отмена' : 'Отменить изменения';
$afterActionMessage = ($model->isNewRecord) ? 'Счёт успешно добавлен' : 'Счёт успешно изменен';

$this->registerJs(<<<JS
    $('#item-edit-form').on('beforeSubmit', function(e){       
        var form = $(this);
        
        $.ajax({
		  url: '{$actionUrl}',
		  method: 'PUT',
		  data: { data : form.serialize() },
		  dataType: 'html'
		}).done(function( data ) {
		   $.pjax.reload({container:"#cards_and_bank_accounts"});  //Reload ListView
		   $.arcticmodal('close');
		   $('#_modal-message-text').text('{$afterActionMessage}');
		   $('#_modal-message').arcticmodal();   
		});
        
        return false;
    });
JS
);

?>
<h2 class="modal__title"><?= $modalTitle ?></h2>
<div class="modal__body">
	<?php
	$form = ActiveForm::begin([
		'id'                     => 'item-edit-form',
		'action'                 => $actionUrl,
		'enableAjaxValidation'   => true,
		'enableClientValidation' => true,
		'validateOnChange'       => false,
		'validateOnBlur'         => false,
		'validateOnSubmit'       => true,
		'options'                => [
			'class' => 'madal-form',
		],
	]);
	?>
	<p class="madal-form__sub">Введите/отредактируйте даные</p>
	<?=	$form->field($model, 'fake_attribute')->hiddenInput(); ?>

	<?= Html::label($model->getBankAccountConstantLabels(PaymentMethodsBankAccountBehavior::FIO)); ?>
	<?= Html::activeTextInput($model, "data[" . PaymentMethodsBankAccountBehavior::FIO . "]", [
		'tabindex'    => 1,
	]); ?>

	<?= Html::label($model->getBankAccountConstantLabels(PaymentMethodsBankAccountBehavior::ACCOUNT_NUMBER)) ?>
	<?= Html::activeTextInput($model, "data[" . PaymentMethodsBankAccountBehavior::ACCOUNT_NUMBER . "]", [
		'tabindex'    => 2,
	]); ?>

	<?= Html::label($model->getBankAccountConstantLabels(PaymentMethodsBankAccountBehavior::BIK)) ?>
	<?= Html::activeTextInput($model, "data[" . PaymentMethodsBankAccountBehavior::BIK . "]", [
		'tabindex'    => 3,
	]); ?>

	<?= Html::submitButton($actionButtonLabel, ['class' => 'btn btn-yell-bordered h-mrg-t-20']) ?>
	<a href="#!" class="modal__canel arcticmodal-close"><?= $cancelButtonLabel ?></a>
	<?php ActiveForm::end(); ?>
</div>