<?php
use app\models\LeaseContracts;
use app\components\extend\Controller;
use app\components\extend\Html;
use app\components\extend\Url;
use yii\bootstrap\ActiveForm;

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

//Yii::$app->session->set(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY, '0000');
/** @var  LeaseContracts $model */
if($model->code!=Yii::$app->session->get(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY)){
    $model->code = null;
}

?>
<?php
$form = ActiveForm::begin([
	'enableClientValidation' => false,
	'enableAjaxValidation'   => true,
	'options'                => [
		'class' => 'lk-form lk-form--row-3-7 lk-form--row-p-20  lk-form--step-1',
	],
]);
?>
<div class="wpapper-con wrapper-con-1 wrapper-con-1--no-pb">
	<div class="wpapper-con wrapper-con-2 bg-blue ">
		<div class="col-1__title">
			<div style="float: right;">
				<?php
				echo Html::a('Скачать договор', ['/lease-contracts/download?contract_id=' . $model->id], [
					'class'  => 'btn btn--next',
					'target' => '_blank',
					'data-pjax' => 0,
				]);
				?>
			</div>
			<p class="h-m-18">Договор аренды жилого помещения</p>
			<h3 class="h-r-13">№ <?= $model->id ?></h3>
		</div>
		<ol class="param-arg h-mrg-t-10">
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
				<?php foreach ($model->participants as $participante): ?>
					<ul class="param-dog-2">
						<li>
							<a href="<?= $participante->user->getProfileUrl() ?>">
								<?= $participante->user->first_name; ?>
							</a>
						</li>
						<li></li>
					</ul>
				<?php endforeach; ?>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Стоимость аренды</li>
				</ul>
				<ul class="param-dog-2">
					<li><?= $model->getPricePerMonth() ?></li>
					<li><?= $model->getPricePerYear() ?></li>
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
					<li>Депозиты</li>
				</ul>
				<ul class="param-dog-2">
					<li><?= $model->getDepositSum() ?></li>
					<li></li>
				</ul>
			</li>
		</ol>
	</div>
</div>
<form action="" class="lk-form lk-form--row-3-7 lk-form--row-p-20">
	<div class="lk-form__wr ">
		<div class="lk-form__title">
			<p>Заполните личные данные</p>
		</div>
        <style>.scans{ display: none; }</style>
		<?= $this->render('//settings/personal_info_passport', [
			'form'     => $form,
			'passport' => $passport,
			'readonly' =>
                $passport->verify == \app\models\UserPassport::VERIFY_VERIFIED?true:false,
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
					<p class='lk-form--p-c'>Согласие</p>
				</div>
				<div class="checkbox h-mrg-t-5">
					<?= $form->field($participant, 'signed')->checkbox([
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
					<p class='lk-form--p-c'>ФИО</p>
				</div>
				<?= $form->field($participant, 'signed_fio')->textInput([
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
					<p class='lk-form--p-c'>Код для подтверждения</p>
				</div>
                <?php if($model->code==Yii::$app->session->get(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY)): ?>
                    <style>.codegen__wr{ display: block!important; } .codegen__btn img{ display: none; } .codegen__btn .codegen__access{ display: block; }</style>
                    <div class="_contract codegen codegen--size-md" >
                        <?= $form->field($model, 'code', [
                            'template' => $buttonTemplate,
                        ])->textInput([
                            'class'       => 'codegen__input',
                            'readonly'       => 'readonly',
                            'placeholder' => $model->getAttributeLabel('code'),
                            'value'=>Yii::$app->session->get(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY),
                        ])->label(false);
                        ?>
                    </div>
                <?php else: ?>
                    <div class="_contract codegen-re codegen--size-md" >
                        <div class="request-cms-code-re btn btn-bl" disabled="disabled">Запросить</div>

                    </div>
                    <div class="_contract codegen codegen--size-md" style="display:none;">
                        <div class="request-cms-code btn btn-bl" <?php //if($participant->signed!=1){ echo 'disabled="disabled"'; } ?>>Запросить</div>
                        <?= $form->field($model, 'code', [
                            'template' => $buttonTemplate,
                        ])->textInput([
                            'class'       => 'codegen__input',
                            'placeholder' => $model->getAttributeLabel('code'),
                            'value'=>Yii::$app->session->get(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY),
                        ])->label(false);
                        ?>
                        <?php if ($model->hasErrors('code')): ?>
                            <p class="sms-code-error help-block help-block-error">Вы должны подтвердить договор с помощью Кода подтверждения</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
			</div>
		</div>
	</div>
	<div class="separator-l"></div>
	<div class="submit-form-row--2">

		<div class="submit-form-row--2__btn">
			<?= Html::submitButton('Подписать договор', ['class' => 'btn btn--next sentSign']) ?>
		</div>
	</div>
<?php ActiveForm::end(); ?>
<?php
$js = <<<JS
if($('#leasecontracts-signed, #leasecontractparticipants-signed').prop('checked')){
    //$('.codegen-re').hide();
    //$('.codegen').show();
}
  $('#leasecontracts-signed, #leasecontractparticipants-signed').on('change', function(){
      if($(this).prop('checked')){
          $('.request-cms-code-re').removeAttr('disabled');
          $('#leasecontracts-code').prop('disabled',false);
          $('.sentSign').prop('disabled',false);
          $('.codegen-re').hide();
            $('.codegen').show();
      }else{
          $('.request-cms-code-re').attr('disabled','disabled');
          $('#leasecontracts-code').prop('disabled',true);
          $('.sentSign').prop('disabled',true);
          $('.codegen-re').show();
            $('.codegen').hide();
      }
  });
JS;

$this->registerJS($js);
?>