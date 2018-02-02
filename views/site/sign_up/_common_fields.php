<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

$buttonTemplate = <<<HTML
<div class="codegen__wr-error" style="display: none">
{error}
</div>
<div class="codegen__wr">
	{input}
	<div class="codegen__btn">
		<img src="/images/load-i.png" class='codegen__load' alt="">
		<p class='codegen__access'>ок</p>
	</div>
</div>
HTML;

?>
	<div class="form-row">
		<div class="form-row__input-wr">
			<?= $form->field($model, 'first_name')->textInput([
				'class'       => 'input input--full input--size-md input--border-l-g',
				'placeholder' => 'ФИО', //$model->getAttributeLabel('first_name'),
			])->label(false);
			?>
		</div>
	</div>

	<div class="form-row">
		<div class="form-row__input-wr">
			<?= $form->field($model, 'email',['errorOptions' => ['class' => 'help-block' ,'encode' => false]])->textInput([
				'class'       => 'input input--full input--size-md input--border-l-g',
				'placeholder' => $model->getAttributeLabel('email'),
			])->label(false);
			?>
		</div>
	</div>

	<div class="form-row">
		<div class="form-row__input-wr">
			<?= $form->field($model, 'password')->passwordInput([
				'class'       => 'input input--full input--size-md input--border-l-g',
				'placeholder' => $model->getAttributeLabel('password'),
			])->label(false);
			?>
		</div>
	</div>

	<div class="form-row">
		<div class="form-row__input-wr">
			<?= $form->field($model, 'password_repeat')->passwordInput([
				'class'       => 'input input--full input--size-md input--border-l-g',
				'placeholder' => $model->getAttributeLabel('password_repeat'),
			])->label(false);
			?>
		</div>
	</div>

	<div class="cols cols--h-sm-gap cols--v-sm-gap">
		<div class="cols__col--reg cols__col--reg--1">
			<div class="form-row">
				<div class="form-row__input-wr">
					<?=
					$form->field($model, 'phone')->textInput([
						'class'       => 'input input--full input--size-md input--border-l-g phoneInput phoneMask',
						'placeholder' => '+7 (___) ___-__-__',
					])->label(false);
					?>
				</div>
			</div>
		</div>
		<div class="cols__col--reg cols__col--reg--2">
			<div class="form-row">
				<div class="form-row__input-wr">
					<div class="_signup codegen">
						<div class="btn btn-w">Подтвердить</div>
						<?= $form->field($model, 'code', [
							'template' => $buttonTemplate,
						])->textInput([
							'class'       => 'codegen__input',
							'placeholder' => $model->getAttributeLabel('code'),
						])->label(false);
						?>
					</div>
					<div class="codegen__note">
						Введите код/Повторите запрос
					</div>
				</div>
			</div>
		</div>
	</div>


<?=
$form->field($model, 'role', [
	'template' => '{input}',
])->hiddenInput([
	'value' => User::ROLE_LESSOR,
])->label(false);
?>