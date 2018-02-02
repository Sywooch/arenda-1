<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\widgets\MyKladr;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

?>
<div class="lk-form__row">
	<div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'region'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
		<?php echo Html::hiddenInput('RealEstate[region_id]', $model->region_id, ['id' => 'RealEstate_region_id']); ?>
		<?= $form->field($model, 'region')->widget(AutoComplete::classname(), [
			'clientOptions' => [
				'source' => Url::to(['reference/cian-region']),
			],
			'clientEvents' => [
				'select' => 'function (event, ui) { $("#RealEstate_region_id").val(ui.item.value); $(event.target).val(ui.item.label); return false; }',
			],
			'options' => [
				'class' => 'input--main modal--big__input-lg',
			]
		]) ?>		
	</div>
</div>
<div class="lk-form__row"  id="city_e_container" style="display: <?php echo ($model->region == 'Москва' || $model->region == 'Санкт-Петербург') ? 'none' : 'block'; ?>">
	<div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'city'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
		<?= $form->field($model, 'city')->widget(MyKladr::className(), [
			'type'    => MyKladr::TYPE_CITY,
			'options' => [
				'class' => 'input--main modal--big__input-lg',
				'data-kladr-id' => $model->city_id,
			]
		])->label(false); ?>
	</div>
</div>
<div class="lk-form__row" id="district_e_container" style="display: <?php echo ($model->region == 'Москва' || $model->region == 'Санкт-Петербург' || $model->city == 'Москва' || $model->city == 'Санкт-Петербург') ? 'none' : 'block'; ?>">
	<div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'district'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
		<?php echo Html::hiddenInput('RealEstate[district_id]', $model->district_id, ['id' => 'RealEstate_district_id']); ?>
		<?= $form->field($model, 'district')->widget(AutoComplete::classname(), [
			'clientOptions' => [
				'source' => new JsExpression('function(rq, rs) {$.ajax({url: "' . Url::to(['reference/avito-district']) . '", dataType: "json", data: {term: rq.term, city: $("#realestate-city").val()}, success: rs});}'),
			],
			'clientEvents' => [
				'select' => 'function (event, ui) {  $("#RealEstate_district_id").val(ui.item.value); $(event.target).val(ui.item.label); return false; }'
			],
			'options' => [
				'class' => 'input--main modal--big__input-lg'
			]
		]) ?>
	</div>
</div>
<div class="lk-form__row" id="metro_e_container" style="display: <?php echo ($model->region == 'Москва' || $model->region == 'Санкт-Петербург' || $model->city == 'Москва' || $model->city == 'Санкт-Петербург') ? 'block' : 'none'; ?>">
	<div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'metro'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
		<?php echo Html::hiddenInput('RealEstate[metro_id]', $model->metro_id, ['id' => 'RealEstate_metro_id']); ?>
		<?= $form->field($model, 'metro')->widget(AutoComplete::classname(), [
			'clientOptions' => [
				'source' => new JsExpression('function(rq, rs) {$.ajax({url: "' . Url::to(['reference/cian-metro']) . '", dataType: "json", data: {term: rq.term, city: $("#realestate-city").val()}, success: rs});}'),
			],
			'clientEvents' => [
				'select' => 'function (event, ui) {  $("#RealEstate_metro_id").val(ui.item.value); $(event.target).val(ui.item.label); return false; }'
			],
			'options' => [
				'class' => 'input--main modal--big__input-lg'
			]
		]) ?>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'street'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
		<?= $form->field($model, 'street')->widget(MyKladr::className(), [
			'type'    => MyKladr::TYPE_STREET,
			'options' => [
				'class' => 'input--main modal--big__input-lg'
			]
		])->label(false); ?>
	</div>
</div>
<div class="lk-form__row">
	<div class="lk-form__col-l">
        <p class="lk-form--p-c">
            Номер дома, квартиры
        </p>
    </div>
    <div class="lk-form__col-r">
		<div class="modal--big__row modal--big__row--4cols">
			<div class="lk-form--inline">
				<?= $form->field($model, 'dom')->textInput([
					'class'       => 'input--main modal--big__input-sm-r',
					'placeholder' => $model->getAttributeLabel('dom'),
				])->label(false); ?>
			</div>
			<div class="lk-form--inline">
				<?= $form->field($model, 'corps')->textInput([
					'class'       => 'input--main modal--big__input-sm-r',
					'placeholder' => $model->getAttributeLabel('corps'),
				])->label(false); ?>
			</div>
			<div class="lk-form--inline">
				<?= $form->field($model, 'building')->textInput([
					'class'       => 'input--main modal--big__input-sm-r',
					'placeholder' => $model->getAttributeLabel('building'),
				])->label(false); ?>
			</div>
			<div class="lk-form--inline">
				<?= $form->field($model, 'flat')->textInput([
					'class'       => 'input--main modal--big__input-sm-r',
					'placeholder' => $model->getAttributeLabel('flat'),
				])->label(false); ?>
			</div>
		</div>
	</div>
</div>
<?php

$this->registerJs(
<<<ENDJS

$('#realestate-region').on('change autocompleteselect', function() {
	if ($(this).val() == "Москва") { 
		$("#city_e_container,#district_e_container").hide(); 
		$("#metro_e_container").show(); 
		$("#realestate-city_kladr,#realestate-city").val("Москва").attr("data-kladr-id", "7700000000000"); 
		$("#realestate-city_id").val("7700000000000"); 
	} else if($(this).val() == "Санкт-Петербург") { 
		$("#city_e_container,#district_e_container").hide(); 
		$("#metro_e_container").show(); 
		$("#realestate-city_kladr,#realestate-city").val("Санкт-Петербург").attr("data-kladr-id", "7800000000000"); 
		$("#realestate-city_id").val("7800000000000"); 
	} else { 
		$("#city_e_container,#district_e_container").show(); 
		$("#metro_e_container").hide(); 
		$("#realestate-city_kladr,#realestate-city").val("").attr("data-kladr-id", ""); 
		$("#realestate-city_id").val(""); 
	}
});
$('#realestate-city,#realestate-city_kladr').on('change kladrselect', function() {
	if ($(this).val() == "Москва") { 
		$("#district_e_container").hide(); 
		$("#metro_e_container").show(); 
	} else if($(this).val() == "Санкт-Петербург") { 
		$("#district_e_container").hide(); 
		$("#metro_e_container").show(); 
	} else { 
		$("#district_e_container").show(); 
		$("#metro_e_container").hide(); 
	}
});

ENDJS
);