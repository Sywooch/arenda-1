<?php
use app\components\extend\Html;
use app\models\Ads;
use app\components\extend\Url;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;

?>
<?= Html::activeHiddenInput($model, 'date_created') ?>
<div class="wpapper-con wrapper-con-2">
	<div class="form-param-1 ff js-imgUpload js-imgUpload_cover">
		<p class="h-m-18">Обложка</p>
		<?= $this->render('cover', [
			'form'  => $form,
			'model' => $model,
		]); ?>
	</div>
	<div class="form-param-1 ff js-imgUpload">
		<p class="h-m-18">Фотографии</p>
		<?= $this->render('photos', [
			'form'  => $form,
			'model' => $model,
		]); ?>

	</div>
</div>
<div class="separator-l separator-l--m-t"></div>
<div class="submit-form-row--3">
	<div class="submit-form-row--3__link">
		<a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 3]) ?>" class="link link--prev-blue">
			Назад
		</a>
	</div>
	<div class="submit-form-row--3__btn">
		<?= Html::submitButton('Пропустить', ['id' => 'js-imgUpload--btn', 'class' => 'btn btn-w arg_i_add--btn']) ?>
	</div>
</div>
<div id="js-img-upload"></div>