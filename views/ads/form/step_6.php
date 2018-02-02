<?php
use app\components\extend\Html;
use app\models\Ads;
use app\components\extend\Url;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;

?>
<?= Html::activeHiddenInput($model, 'date_created') ?>
<div class="wpapper-con wrapper-con-2">
	<div class="form-param-1 ff">
		<p class="h-m-18">Статус объявления</p>
		<?= $this->render('mini_ad', [
			'form'  => $form,
			'model' => $model,
		]); ?>
	</div>
</div>
<div class="separator-l"></div>
<div class="lk-form__wr">
    <div class="lk-form__title">
        <p>Размещение на сайтах недвижимости</p>
    </div>
    <?= $this->render('additional_options', [
        'form'  => $form,
        'model' => $model,
    ]); ?>
</div>
<div class="separator-l separator-l--m-t"></div>
<div class="submit-form-row submit-form-row--3">
	<div class="submit-form-row__link">
		<a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 5]) ?>" class="link link--prev-blue">
			Назад
		</a>
	</div>
	<div class="submit-form-row__btn">
		<?= Html::submitButton('Завершить', ['class' => 'btn btn-y h-b-14 arg_i_add--btn']) ?>
	</div>
</div>