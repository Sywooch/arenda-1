<?php
/**
 * @var \app\models\RealEstate $model
 */

use app\components\extend\Html;
use app\components\extend\Url;
use yii\bootstrap\ActiveForm;
use limion\jqueryfileupload\JQueryFileUpload;
use app\components\widgets\MyKladr;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

if (!$model->isNewRecord) {
    $checkUrl = Url::to(['address-changed', 'id' => $model->id]);

    $checkJs = <<<JS
    $.arcticmodal('close');
    $.post('{$checkUrl}', window.ESTATE_FORM_DATA, function (response) {
        if (response.changed){
            $('#check-modal').arcticmodal();
        } else {
            var form = "";
            saveAddress(form);
        } 
    }, 'json');
JS;

} else{
    $checkJs = 'var form = ""; saveAddress(true);';
}

$actionUrl = ($model->isNewRecord) ? Url::to(['create']) : Url::to(['update', 'id' => $model->id]);
$modalTitle = ($model->isNewRecord) ? 'Добавление объекта недвижимости' : 'Редактирование объекта недвижимости';
$actionButtonLabel = ($model->isNewRecord) ? 'Создать объект' : 'Сохранить изменения';
$afterActionMessage = ($model->isNewRecord) ? 'Объект успешно добавлен' : 'Объект успешно изменен';

$this->registerJs("
    $('#item-edit-form').on('beforeSubmit', function(e){       
        window.ESTATE_FORM_DATA = $(this).serialize();
        
        {$checkJs}
        		                     
        return false;
    });

    function saveAddress(check){
        if (check == undefined)
            check = '';
        $.ajax({
		  url: '{$actionUrl}',
		  method: 'PUT',
		  data: { data : window.ESTATE_FORM_DATA, check: check },
		  dataType: 'html'
		}).done(function( data ) {
		   $.pjax.reload({container:'#real-estate-list'});  //Reload ListView
		   $.arcticmodal('close');
		   $('#_modal-message-text').text('{$afterActionMessage}');
		   $('#_modal-message').arcticmodal();   
		});
    }
"
);

?>

<h2 class="modal__title"><?= $modalTitle ?></h2>
<div class="modal__body modal__body--big">
	<?php
	$form = ActiveForm::begin([
		'id'                     => 'item-edit-form',
		'action'                 => $actionUrl,
		'enableAjaxValidation'   => true,
		'enableClientValidation' => true,
		'validateOnChange'       => true,
		'validateOnBlur'         => false,
		'validateOnSubmit'       => true,
		'options'                => [
			'enctype' => 'multipart/form-data',
		],
	]);
	?>

	<div class="modal--big__row modal--big__row--lg">
		<div class="lk-form--inline">
			<?= $form->field($model, 'title')->textInput([
				'class'       => 'input--main modal--big__input-lg',
				'placeholder' => $model->getAttributeLabel('title'),
			])->label(false); ?>
		</div>
	</div>
	<div class="modal--big__row modal--big__row--lg">
		<div class="lk-form--inline">
			<?php echo Html::hiddenInput('RealEstate[region_id]', $model->region_id, ['id' => 'RealEstate_region_id']); ?>
			<?= $form->field($model, 'region')->widget(AutoComplete::classname(), [
				'clientOptions' => [
					'source' => Url::to(['reference/cian-region']),
				],
				'clientEvents' => [
					'select' => 'function (event, ui) { $("#RealEstate_region_id").val(ui.item.value); $(event.target).val(ui.item.label); return false; }',
				],
				'options' => [
					'placeHolder' => $model->getAttributeLabel('region'),
					'class' => 'input--main modal--big__input-lg',
				]
			]) ?>
		</div>
	</div>
	<div class="modal--big__row modal--big__row--lg" id="city_e_container" style="display: <?php echo ($model->region == 'Москва' || $model->region == 'Санкт-Петербург') ? 'none' : 'block'; ?>">
		<div class="lk-form--inline">
			<?= $form->field($model, 'city')->widget(MyKladr::className(), [
				'type'    => MyKladr::TYPE_CITY,
				'options' => [
					'placeHolder' => $model->getAttributeLabel('city'),
					'class' => 'input--main modal--big__input-lg',
					'data-kladr-id' => $model->city_id,
				]
			])->label(false); ?>
		</div>
	</div>
	<div class="modal--big__row modal--big__row--lg" id="district_e_container" style="display: <?php echo ($model->region == 'Москва' || $model->region == 'Санкт-Петербург' || $model->city == 'Москва' || $model->city == 'Санкт-Петербург') ? 'none' : 'block'; ?>">
		<div class="lk-form--inline">
			<?php echo Html::hiddenInput('RealEstate[district_id]', $model->district_id, ['id' => 'RealEstate_district_id']); ?>
			<?= $form->field($model, 'district')->widget(AutoComplete::classname(), [
				'clientOptions' => [
					'source' => new JsExpression('function(rq, rs) {$.ajax({url: "' . Url::to(['reference/avito-district']) . '", dataType: "json", data: {term: rq.term, city: $("#realestate-city").val()}, success: rs});}'),
				],
				'clientEvents' => [
					'select' => 'function (event, ui) {  $("#RealEstate_district_id").val(ui.item.value); $(event.target).val(ui.item.label); return false; }'
				],
				'options' => [
					'placeHolder' => $model->getAttributeLabel('district'),
					'class' => 'input--main modal--big__input-lg'
				]
			]) ?>
		</div>
	</div>
	<div class="modal--big__row modal--big__row--lg" id="metro_e_container" style="display: <?php echo ($model->region == 'Москва' || $model->region == 'Санкт-Петербург' || $model->city == 'Москва' || $model->city == 'Санкт-Петербург') ? 'block' : 'none'; ?>">
		<div class="lk-form--inline">
			<?php echo Html::hiddenInput('RealEstate[metro_id]', $model->metro_id, ['id' => 'RealEstate_metro_id']); ?>
			<?= $form->field($model, 'metro')->widget(AutoComplete::classname(), [
				'clientOptions' => [
					'source' => new JsExpression('function(rq, rs) {$.ajax({url: "' . Url::to(['reference/cian-metro']) . '", dataType: "json", data: {term: rq.term, city: $("#realestate-city").val()}, success: rs});}'),
				],
				'clientEvents' => [
					'select' => 'function (event, ui) {  $("#RealEstate_metro_id").val(ui.item.value); $(event.target).val(ui.item.label); return false; }'
				],
				'options' => [
					'placeHolder' => $model->getAttributeLabel('metro'),
					'class' => 'input--main modal--big__input-lg'
				]
			]) ?>
		</div>
	</div>
	<div class="modal--big__row modal--big__row--lg">
		<div class="lk-form--inline">
			<?= $form->field($model, 'street')->widget(MyKladr::className(), [
				'type'    => MyKladr::TYPE_STREET,
				'options' => [
					'placeHolder' => $model->getAttributeLabel('street'),
					'class' => 'input--main modal--big__input-lg'
				]
			])->label(false); ?>
		</div>
	</div>
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
	<div>
		<?php
		echo Html::activeHiddenInput($model, 'cover_image_id_input', ['id' => 'cover_image_id_input']);

		echo JQueryFileUpload::widget([
			//'id' => 'cover-image-input',
			'model'         => $model,
			'attribute'     => 'cover_image',
			'url'           => ['image-upload'], // your route for saving images,
			'appearance'    => 'plus', // available values: 'ui','plus' or 'basic'
			'mainView'      => '@app/views/real-estate/_form_cover_upload',
			'options'       => ['accept' => 'image/*'],
			'clientOptions' => [
				'maxFileSize'      => 2000000,
				'dataType'         => 'json',
				'acceptFileTypes'  => new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
				'autoUpload'       => true,
				'previewMaxWidth'  => '400',
				'previewMaxHeight' => '400',
			],
			'clientEvents'  => [
				'add'  => "function (e, data) {
				    $('.__submit').prop('disabled', true);
				}",
				'done' => "function (e, data) { 					
 				    $.each(data.result.files, function (index, file) {
 				       var canvas = data.files[0].preview;
                       var dataURL = canvas.toDataURL();
                       var img = $('<img/>');
                       img.attr('src', file.thumbnailUrl);
                       $('.upload-grid__item.upload-grid__item--big .js-imgUpload--imglist').html('').append(img);
                       $('#cover_image_id_input').val(file.id);                    
		            });
		            $('.__submit').prop('disabled', false);
			    }",
			],
		]);
		?>
	</div>
    <?php
    if($estateUser!=null){
        echo Html::button($actionButtonLabel, ['class' => 'btn btn-y modal--big__input__button showEditUser']);
        echo Html::submitButton($actionButtonLabel, ['class' => 'btn btn-y modal--big__input__button __submit sentEstate','style'=>'display:none;']);
    }else{
        echo Html::submitButton($actionButtonLabel, ['class' => 'btn btn-y modal--big__input__button __submit']);
    } ?>
	<?php ActiveForm::end(); ?>

    <?php
    if($estateUser!=null){
        $form = ActiveForm::begin([
            'id'                     => 'user-edit-form',
            'action'                 => $actionUrl,
            'enableAjaxValidation'   => true,
            'enableClientValidation' => true,
            'validateOnChange'       => true,
            'validateOnBlur'         => false,
            'validateOnSubmit'       => true,
            'options'                => [
                'enctype' => 'multipart/form-data',
                'style'   => 'display:none;'
            ],
        ]);
        ?>
        <div class="modal--big__row modal--big__row--lg">
            <div class="lk-form--inline">
                <?= $form->field($estateUser, 'last_name')->textInput([
                    'class'       => 'input--main modal--big__input-lg',
                    'placeholder' => $estateUser->getAttributeLabel('last_name'),
                ])->label(false); ?>
            </div>
        </div>
        <div class="modal--big__row modal--big__row--lg">
            <div class="lk-form--inline">
                <?= $form->field($estateUser, 'first_name')->textInput([
                    'class'       => 'input--main modal--big__input-lg',
                    'placeholder' => $estateUser->getAttributeLabel('first_name'),
                ])->label(false); ?>
            </div>
        </div>
        <div class="modal--big__row modal--big__row--lg">
            <div class="lk-form--inline">
                <?= $form->field($estateUser, 'middle_name')->textInput([
                    'class'       => 'input--main modal--big__input-lg',
                    'placeholder' => $estateUser->getAttributeLabel('middle_name'),
                ])->label(false); ?>
            </div>
        </div>
        <?= Html::button('Отправить объект на проверку', [
                'class' => 'btn btn-y modal--big__input__button sentUser',
        ]) ?>
    <?php ActiveForm::end();
    } ?>
</div>


<?php

$this->registerJs(
<<<ENDJS
$('.sentUser').click(function(){
    $('#user-edit-form').yiiActiveForm('validate',true);
    $(this).prop('disabled',true);
    setTimeout(function(){
        if (!$("#user-edit-form").find(".has-error").length) {
            $.ajax({
              method: "POST",
              url: "/real-estate/saveuser",
              data: $("#user-edit-form").serialize(),
            })
              .done(function( msg ) {
               if(msg=='ok'){
               $('.sentEstate').click();
                $('#user-edit-form').hide();
                $('#item-edit-form').show();
                $('.showEditUser').hide();
                $('.sentEstate').show();
               }else{
                $('.sentUser').prop('disabled',false);
               } 
              });
        }else{
            $('.sentUser').prop('disabled',false);
        }
        
    }, 1000);
    

    
});

$('.showEditUser').click(function(){
    $('#item-edit-form').hide();
    $('#user-edit-form').show();
});
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