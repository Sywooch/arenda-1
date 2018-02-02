<?php
use app\components\extend\Url;
use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\behaviors\payment_methods\PaymentMethodsCardBehavior;

$actionUrl = ($model->isNewRecord) ? Url::to(['create', 'type' => $model->type]) : Url::to(['update', 'id' => $model->id]);
$modalTitle = ($model->isNewRecord) ? 'Добавление карты' : 'Редактирование данныx карты';
$actionButtonLabel = ($model->isNewRecord) ? 'Добавить' : 'Сохранить изменения';
$cancelButtonLabel = ($model->isNewRecord) ? 'Отмена' : 'Отменить изменения';
$afterActionMessage = ($model->isNewRecord) ? 'Карта успешно добавлена' : 'Карта успешно изменена';

$this->registerJs(<<<JS
	inputMaskInit();
	
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
	<?=	$form->field($model, 'fake_attribute')->hiddenInput(); ?>
	<div class="madal-form__card">
		<?=  Html::activeTextInput($model, "data[" . PaymentMethodsCardBehavior::CARD_NUMBER . "]", [
			'tabindex'    => 1,
			'class'       => 'in-b cardMask',
			'placeholder' => 'Номер карты',
		]); ?>
		<label for="m-f-c1">Введите верный номер карты</label>
		<div class="madal-form__card--dateRow">
			<p>Срок действия карты:</p>
			<?= Html::activeTextInput($model, "data[" . PaymentMethodsCardBehavior::VALID_MONTH . "]", [
				'id'          => 'm-f-c1',
				'tabindex'    => 2,
				'class'       => 'in-s twoMask',
				'placeholder' => 'ММ',
			]); ?>
			<?= Html::activeTextInput($model, "data[" . PaymentMethodsCardBehavior::VALID_YEAR . "]", [
				'id'          => 'm-f-c2',
				'tabindex'    => 3,
				'class'       => 'in-s twoMask',
				'placeholder' => 'ГГ',
			]); ?>
			<?php if(isset(Yii::$app->user->identity->assignedRoles[\app\models\User::ROLE_CUSTOMER]))
			{?>
			<?= Html::activeTextInput($model, "data[" . PaymentMethodsCardBehavior::CVV_CVC . "]", [
				'id'          => 'm-f-c3',
				'tabindex'    => 4,
				'class'       => 'in-s in-last threeMask',
				'placeholder' => 'CVC',
			]); ?>
			<?php } ?>
			<p></p>
			<label class="in-s" for="m-f-c1">1*</label>
			<label class="in-s" for="m-f-c2">2*</label>
			<?php if(isset(Yii::$app->user->identity->assignedRoles[\app\models\User::ROLE_CUSTOMER]))
			{?>
			<label class="in-s in-last" for="m-f-c3">3*</label>
			<?php } ?>
		</div>
	</div>
	<p class="mrg-t-15">Введите/отредактируйте данные</p>
	<p class="mrg-t-15">1* Месяц действия карты; 2* Год действия карты.</p>
	<?php if(isset(Yii::$app->user->identity->assignedRoles[\app\models\User::ROLE_CUSTOMER]))
	{?>
	<p class="mrg-t-15">3* Трехзначный код с обратной стороны карты.</p>
	<?php } ?>
	<?= Html::submitButton($actionButtonLabel, ['class' => 'btn btn-yell-bordered h-mrg-t-20']) ?>
	<a href="#!" class="modal__canel arcticmodal-close"><?= $cancelButtonLabel ?></a>
	<?php ActiveForm::end(); ?>
</div>