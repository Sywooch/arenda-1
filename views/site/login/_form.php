<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\LoginForm */

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\components\extend\Url;

?>


<?php
$form = ActiveForm::begin([
	'id'                     => 'login-form',
	'action'                 => Url::to(['/site/login']),
	'enableAjaxValidation'   => true,
	'enableClientValidation' => true,
	'validateOnChange'       => true,
	'validateOnBlur'         => false,
	'validateOnSubmit'       => true,
	'options'                => [
		'class' => 'madal-login',
	],
]);
?>

	<p class="madal-login__sub">Еще не зарегистрированы?
		<span class="arcticmodal-close js-modal-link" data-id-modal="registration">Регистрация</span>
	</p>

<?=
$form->field($model, 'email')->textInput([
	'autofocus'   => true,
	'placeholder' => 'Введите ваш ' . $model->getAttributeLabel('email'),
])->label(false);
?>

<?=
$form->field($model, 'password')->passwordInput([
	'placeholder' => 'Введите ваш ' . $model->getAttributeLabel('password'),
])->label(false);
?>

	<div class="checkbox">
		<?=
		$form->field($model, 'rememberMe')->checkbox([
			'template' => '{input}{label}',
		])
		?>
	</div>

<?= Html::submitButton('Войти', ['class' => 'btn btn-y', 'name' => 'login-button']) ?>

	<a href="#!" class="modal__canel arcticmodal-close js-modal-link" data-id-modal="password-recovery">
		Восстановить пароль
	</a>

<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
  $('#login-form').on('click', 'input', function(){
      $('#login-form .has-error').removeClass('has-error');
      $('#login-form .help-block-error').text('');
  });
JS;

$this->registerJS($js);
