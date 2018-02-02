<?php

use app\components\extend\Html;
use app\models\UserCustomerInfo;
use app\components\widgets\SideHelper;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $model app\models\UserCustomerInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<?=
$this->render('common_info', [
	'model' => $model,
	'user'  => $user,
	'form'  => $form,
    'readonly' => $readonly,
]);
?>
<div class="title-row title-row--empty js-drop-lk-edit">
	<div class="title-row__title">
		<p class="h2">Граждане, постоянно  проживающие совместно с Нанимателем</p>
	</div>
</div>
<div class="contant-row lk-edit--hide">
	<div class="js-members">
		<style> div.btn.btn-lk-edit{
				margin-left: 16px;
			}</style>
		<div class="lk-form__members">
			<?php
			echo $this->render('customer_info/_addational_contact', [
				'form'         => $form,
				'model'        => $model,
				'addationals' => $model->addationals,
			]);
			?>
		</div>
		<div class="lk-form__wr--pw">
			<div class="lk-form__row lk-form--step-1__center">
				<div class="lk-form__col-r ">
					<?=
					Html::a('+ Добавить еще участника', '#', [
						'class'   => 'btn btn--add',
						'onclick' => 'Contract.Participant.duplicateFields($(this));return false;',
						'data'    => [
							'selector' => '.js-member-contain',
						],
					]);
					?>
				</div>
			</div>
		</div>
	</div>
	<div style="display: none;">
		<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_LAST_NAME) ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_LAST_NAME) ?></p>
					</div>
					<?= Html::activeTextInput($model, 'data' . UserCustomerInfo::DATA_ADDITIONAL_LAST_NAME, ['class' => 'input--main lk-form--input-md']); ?>
				</div>
			</div>
		</div>
		<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_FIRST_NAME) ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_FIRST_NAME) ?></p>
					</div>
					<?= Html::activeTextInput($model, 'data' . UserCustomerInfo::DATA_ADDITIONAL_FIRST_NAME, ['class' => 'input--main lk-form--input-md']); ?>
				</div>
			</div>
		</div>
		<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_PHONE) ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_PHONE) ?></p>
					</div>
					<?= Html::activeTextInput($model, 'data' . UserCustomerInfo::DATA_ADDITIONAL_PHONE, ['class' => 'input--main lk-form--input-md']); ?>
				</div>
			</div>
		</div>
		<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_EMAIL) ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_EMAIL) ?></p>
					</div>
					<?= Html::activeTextInput($model, 'data' . UserCustomerInfo::DATA_ADDITIONAL_EMAIL, ['class' => 'input--main lk-form--input-md']); ?>
				</div>
			</div>
		</div>
		<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_IS_TO_ME) ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_ADDITIONAL_IS_TO_ME) ?></p>
					</div>
					<?= Html::activeTextInput($model, 'data' . UserCustomerInfo::DATA_ADDITIONAL_IS_TO_ME, ['class' => 'input--main lk-form--input-md']); ?>
				</div>
			</div>
		</div>
	</div>
</div>

