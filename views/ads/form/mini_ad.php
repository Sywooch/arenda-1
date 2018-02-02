<?php
use app\components\extend\Html;
use app\models\Ads;
use app\components\extend\Url;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;

$active_status = Ads::STATUS_ACTIVE;

$this->registerJs(<<<JS
    $('.__submit_activated_ad').on('click', function(e){
        e.preventDefault();
        
        var form = $(this).closest('form');
        var status_input = $('.ad_status_input');
        
        status_input.val($active_status);
        
        form.submit();
    });
JS
);

?>

<div class="lord_prod">
	<a href="<?= Url::to(['/ads/view', 'id' => $model->primaryKey]); ?>">
		<?php
		echo $model->cover->file->renderImage([
			'width'  => 200,
			'height' => 140,
		]);
		?>
	</a>
	<?php
	$imagesCount = $model->getImages()->count();
	if ($imagesCount > 0) {
		echo Html::tag('i', $imagesCount);
	}
	?>
	<h4 class="h4"><span><?= $model->title; ?></span></h4>
	<div class="lord_prod--cor">
		<ol class="lord_prod-par">
			<li><?= $model->getNumberOfRooms(); ?></li>
			<li><?= $model->getRentTerm(); ?></li>
		</ol>
		<ol class="lord_prod-par">
			<li><?= $model->location_floor ?> этаж из <?= $model->house_floors ?></li>
			<li><?= ($model->hasFacility(Ads::FACILITIES_BALCONY)) ? 'есть балкон' : '&nbsp;'; ?></li>
		</ol>
		<ol class="lord_prod-par">
			<li><?= $model->number_of_rooms_total_area; ?> м<sup>2</sup></li>
			<li><?= $model->number_of_rooms_living_area; ?> м<sup>2</sup></li>
		</ol>
		<ol class="lord_prod-par">
			<li><?= number_format($model->rent_cost_per_month, 0, '.', ' ') ?> <span class="rub">Р</span> в мес</li>
		</ol>
	</div>
	<div class="lord_prod-b-2">
		<?php /*=  Html::activeHiddenInput($model, 'status', ['class' => 'ad_status_input'])*/ ?>
		<div class="Check_fam Check_fam--sq">
			<?php echo Html::activeCheckbox($model, 'status', ['class' => 'ad_status_input', 'value' => Ads::STATUS_ACTIVE, 'uncheck' => Ads::STATUS_DISABLED, 'label' => null, 'id' => 'kjdsgjrdhfj']); ?>
			<label for="kjdsgjrdhfj"><span class="Check_fam__view"></span> Активировать</label>
		</div>
		<!-- div class="btn btn-y h-b-14 __submit_activated_ad">Активировать</div -->
		<h2 class="h-i-13">Активируйте Ваше объявление, чтобы найти подходящих кандидатов и получать заявки.</h2>
	</div>
</div>