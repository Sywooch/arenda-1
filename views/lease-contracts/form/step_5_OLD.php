<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\extend\Controller;
use app\models\LeaseContracts;

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

/** @var $model LeaseContracts */
//Yii::$app->session->set(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY, '0000');
$model->code = null;
?>
<?= Html::activeHiddenInput($model, 'date_created') ?>
<div class="wpapper-con wrapper-con-1">
	<div class="wpapper-con wrapper-con-2 bg-blue">
		<p class="h-m-18">Договор аренды жилого помещения</p>
		<h3 class="h-r-13">№ <?= $model->id ?></h3>
		<ol class="param-arg">
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Недвижимость</li>
				</ul>
				<ul class="param-dog-2">
					<li><?= $model->estate->getFullAddress() ?></li>
					<li><?= $model->estate->title ?></li>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Срок аренды</li>
				</ul>
				<ul class="param-dog-2">
					<li>
						с
						<?php
						$startDate = $model->date_begin;
						$contents = [];
						$contents[] = date('d', $startDate);
						$contents[] = Controller::monthLabels(date('m', $startDate), 2);
						$contents[] = date('Y', $startDate);
						echo implode(' ', $contents);
						?>
						по
						<?php
						$endDate = (strtotime('+' . $model->lease_term . 'month', $model->date_begin));
						$contents = [];
						$contents[] = date('d', $endDate);
						$contents[] = Controller::monthLabels(date('m', $endDate), 2);
						$contents[] = date('Y', $endDate);
						echo implode(' ', $contents);
						?>
					</li>
					<li><?= LeaseContracts::getLeaseTermLabels($model->lease_term) ?></li>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Участники</li>
				</ul>
				<ul class="param-dog-2">
					<?php foreach ($model->participants as $participant): ?>
					<li>
						<a href="<?= $participant->user->getProfileUrl() ?>">
							<?= $participant->user->first_name; ?>
						</a>
					</li>
					<li></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Стоимость аренды</li>
				</ul>
				<ul class="param-dog-2">
					<li><?= number_format($model->price_per_month, 0, '.', ' ') ?> <span class="rub">Р</span> в мес.</li>
					<li><?= number_format($model->price_per_month * 12, 0, '.', ' ') ?> <span class="rub">Р</span> в год</li>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Оплата</li>
				</ul>
				<ul class="param-dog-2">
					<li>По <?= $model->payment_date ?> числам месяца</li>
					<li><?php
						$startDate  = $model->date_begin;
						$contents   = [];
						$contents[] = date('d', $startDate);
						$contents[] = Controller::monthLabels(date('m', $startDate), 2);
						echo implode(' ', $contents);
						?> первая оплата</li>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Депозит</li>
				</ul>
				<ul class="param-dog-2">
					<li><?= $model->getDepositSum() ?></li>
				</ul>
			</li>
		</ol>
	</div>
</div>
<div class="separator-l separator-show"></div>
<div class="lk-form__wr ">
	<div class="lk-form__title">
		<p>Заполните личные данные</p>
	</div>
	<?= $this->render('//settings/personal_info_passport', [
		'form'     => $form,
		'passport' => $passport,
		'readonly' => true,
	]) ?>
</div>
<div class="separator-l"></div>
<div class="lk-form__wr ">
	<div class="lk-form__title">
		<p>Подтверждение</p>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">Согласие</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form__hidden-subt">
				<p class="lk-form--p-c">Согласие</p>
			</div>
			<div class="checkbox h-mrg-t-10">
				<?= $form->field($model, 'confirmed')->checkbox([
					'template' => "{error}{input}{label}",
				]); ?>
			</div>
		</div>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c">ФИО</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form__hidden-subt">
				<p class="lk-form--p-c">ФИО</p>
			</div>
			<?= $form->field($model, 'signed_fio')->textInput([
				'class'    => 'input--main input--full input--plholder-b',
				'readonly' => 'readonly',
			]);
			?>
		</div>
	</div>
	<div class="lk-form__row">
		<div class="lk-form__col-l">
			<p class="lk-form--p-c-np">
				Код для подтверждения
			</p>
			<p class="codegen_sub-right">
				Нажмите кнопку Запросить и код
				подтверждения будет Вам
				направлен по смс
			</p>
		</div>
		<div class="lk-form__col-r">
			<div class="lk-form__hidden-subt">
				<p class="lk-form--p-c">Код для подтверждения</p>
			</div>
			<div class="_contract codegen codegen--size-md h-pad-t-15">
				<div class="btn btn-bl">Запросить</div>
				<?= $form->field($model, 'code', [
					'template' => $buttonTemplate,
				])->textInput([
					'class'       => 'codegen__input',
					'placeholder' => $model->getAttributeLabel('code'),
				])->label(false);
				?>
				<div class="codegen__note">
					Введите код/Повторите запрос
				</div>
			</div>
			<?php if ($model->hasErrors('code')): ?>
				<p class="sms-code-error help-block help-block-error">Вы должны подтвердить договор с помощью Кода подтверждения</p>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="separator-l"></div>
<div class="submit-form-row--2">
	<div class="submit-form-row--2__link">
		<a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 4]) ?>" class="link link--prev-blue">
			Назад
		</a>
	</div>
	<div class="submit-form-row--2__btn">
		<?= Html::submitButton('Вперед', ['class' => 'btn btn--next']) ?>
	</div>
</div>


