<?php

use app\components\extend\Html;
use app\components\extend\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';

$actionUrl = Url::to(['/site/request-password-reset']);

$this->registerJs(<<<JS
    $('#request-password-reset-form').on('beforeSubmit', function(e){       
        var form = $(this);
        
        $.ajax({
		  url: '{$actionUrl}',
		  method: 'PUT',
		  data: { data: form.serialize() },
		  dataType: 'html'
		}).done(function( data ) {
		   $('#password-recovery .modal__body .madal-login').html(data);		   
		});
        
        return false;
    });
JS
);
?>
<div class="madal-login">
	<?php
	$form = ActiveForm::begin([
		'id'                     => 'request-password-reset-form',
		'action'                 => Url::to(['/site/request-password-reset']),
		'enableClientValidation' => true,
		'enableAjaxValidation'   => true,
	]);
	?>

	<?= $form->field($model, 'email')->textInput([
		'class'       => 'form-control',
		'placeholder' => 'Введите ваш E-mail',
	]) ?>
	<div class="form-group">
		<?= Html::submitButton('Восстановить', ['class' => 'btn btn-y h-mrg-t-0']) ?>
	</div>
	<?php ActiveForm::end(); ?>
	<p class="form-after-small">
		<a href="#!" class="link link--crimson arcticmodal-close js-modal-link" data-id-modal="login">Войти</a>
		или
		<a href="#!" class="link link--crimson arcticmodal-close js-modal-link" data-id-modal="registration">Зарегистрироватся</a>
	</p>
</div>