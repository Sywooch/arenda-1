<?php
use app\components\extend\Html;
use app\models\Ads;
use app\components\extend\Url;
use app\components\widgets\CustomDropdown\CustomDropdown;

?>
<div class="lk-form__wr">
	<div class="lk-form__title">
		<p>Укажите детали</p>
	</div>
	<?= $this->render('details_info', [
		'form'  => $form,
		'model' => $model,
	]); ?>
</div>
<div class="separator-l"></div>
<div class="submit-form-row--2">
	<div class="submit-form-row--2__link">
		<a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 1]) ?>" class="link link--prev-blue">
			Назад
		</a>
	</div>
	<div class="submit-form-row--2__btn">
		<?= Html::submitButton('Вперёд', ['class' => 'btn btn--next']) ?>
	</div>
</div>