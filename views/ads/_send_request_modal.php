<?php
use yii\bootstrap\ActiveForm;
use app\components\extend\Html;
use app\components\extend\Url;

$actionUrl = Url::to(['/applications/create', 'ad_id' => $model->primaryKey]);
$afterActionMessage = 'Заявка подана';

$this->registerJs(<<<JS
    $('#send-request-form').on('beforeSubmit', function(e){       
        var form = $(this);
                        
        $.ajax({
		  url: '{$actionUrl}',
		  method: 'GET',
		  data: { data : form.serialize() },
		  dataType: 'html'
		}).done(function( data ) {		 
		   $.arcticmodal('close');
		   data = JSON.parse(data);
		   $('#_modal-message-text').text('');//{$afterActionMessage}
		   $('#_modal-message-text').append(data.text);//{$afterActionMessage}
		   $('#_modal-message').arcticmodal();   
		});
		                     
        return false;
    });
JS
);

?>
<!-- sendReq -->
<div style="display: none;">
	<div class="box-modal modal" id="sendRequest">
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title">Отправка заявки</h2>
			<div class="modal__body">
				<?php if (Yii::$app->user->isGuest): ?>
					<p class="madal-login__sub">
						Для отправки заявки Вам нужно
						<span class="link link--crimson arcticmodal-close js-modal-link"
						      data-id-modal="login">Войти</span>
					</p>

					<p class="madal-login__sub">
						Еще не зарегистрированы?
						<span class="arcticmodal-close js-modal-link" data-id-modal="registration">Регистрация</span>
					</p>
				<?php else: ?>
					<?php
					$formModel = new \app\models\forms\AdApplicationSendForm([
						'user_id' => Yii::$app->user->id,
						'ad_id'   => $model->primaryKey,
					]);

					$form = ActiveForm::begin([
						'id'                     => 'send-request-form',
						'action'                 => $actionUrl,
						'enableClientValidation' => false,
						'enableAjaxValidation'   => true,
					]);
					?>

					<?= $form->field($formModel, 'fake_field')->textInput(); ?>

					<?= $form->field($formModel, 'comment')->textarea([
						'class'       => 'textarea textarea--full',
						'rows'        => 10,
						'cols'        => 30,
						'placeholder' => 'Комментарий если нужно',
					]); ?>

					<?= Html::submitButton('Отправить', ['class' => 'class="btn btn-y modal--big__input__button __submit"']) ?>

					<?php ActiveForm::end(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<!-- end sendReq -->