<?php
use app\components\extend\Html;
use app\models\Ads;
use app\components\extend\Url;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;

?>
<?= Html::activeHiddenInput($model, 'date_created') ?>

<div class="wpapper-con wrapper-con-2 js-calc-cost">
	<div class="form-param-1 ff">
		<p class="h-m-18">Проверка жильцов</p>
		<?= $this->render('screening', [
			'form'  => $form,
			'model' => $model,
		]); ?>
	</div>
</div>
<div class="separator-l"></div>
<div class="submit-form-row submit-form-row--4">
	<div class="submit-form-row__link">
		<a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 4]) ?>" class="link link--prev-blue">
			Назад
		</a>
	</div>
	<div class="submit-form-row__center">
		<div class="result-box">
			<h2 class="result-box__t">Стоимость: <i class="js-cost">0 <span class="rub">Р</span></i></h2>
			<h2 class="result-box__b">Платят наниматели</h2>
		</div>
	</div>
	<div class="submit-form-row__btn">
		<?= Html::submitButton('Вперёд', ['class' => 'btn btn-y arg_i_add--btn']) ?>
	</div>
</div>
