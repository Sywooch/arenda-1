<?php

use yii\bootstrap\ActiveForm;
use app\components\extend\Html;
use app\components\extend\Url;

?>

<?php
$rand = md5(mt_rand(0, 1000) + microtime());
$form = ActiveForm::begin([
	'id'                     => 'form-signup-' . $rand,
	'action'                 => Url::to(['/site/signup']),
	'enableAjaxValidation'   => true,
	'enableClientValidation' => false,
	'validateOnChange'       => false,
	'validateOnBlur'         => false,
]);
$commonFields = $this->render('_common_fields', [
	'model' => $model,
	'form'  => $form,
]);
?>
<?= $commonFields; ?>
<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn--w100 btn-yell-bordered h-mrg-t-20', 'name' => 'signup-button']) ?>

	<div class="form-after-small_checkbox form-after-small">
		<div class="checkbox h-mrg-t-5">
			<?= $form->field($model, 'confirmed')->checkbox([
				'id' => 'signupform-confirmed-' . $rand,
				'template' => "{error}{input}{label}",
			])->label('При создании учетной записи, вы согласны с нашими<br>
                                        <a href="#!" class="link link--crimson">
                                            Условиями пользования сайтом
                                        </a>'); ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>