<?php

use app\components\extend\Html;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\models\UserPassport;
use limion\jqueryfileupload\JQueryFileUpload;

/**
 * @property UserPassport $passport;
 *
 **/

if (!isset($readonly)) {
	$readonly = false;
}

?>
<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-set-p required"><?= Html::activeLabel($passport, 'serial_nr') ?></p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form__hidden-subt">
			<p class="lk-set-p required"><?= Html::activeLabel($passport, 'serial_nr') ?></p>
		</div>
		<?= $form->field($passport, 'serial_nr')->textInput([
			'class'    => 'input--main lk-form--input-sm pasportMask',
			'readonly' => $readonly,
		])->label(false); ?>
	</div>
</div>

<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-set-p required"><?= Html::activeLabel($passport, 'issued_by') ?></p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form__hidden-subt">
			<p class="lk-set-p required"><?= Html::activeLabel($passport, 'issued_by') ?></p>
		</div>
		<?= $form->field($passport, 'issued_by')->textInput([
			'class'    => 'input--main input--full',
			'readonly' => $readonly,
		])->label(false); ?>
	</div>
</div>

<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-set-p required"><?= Html::activeLabel($passport, 'issued_date') ?></p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form__hidden-subt">
			<p class="lk-set-p required"><?= Html::activeLabel($passport, 'issued_date') ?></p>
		</div>
		<?php
		if (!$readonly) {
            echo $form->field($passport, 'issued_date')->widget(AirDatepicker::classname(), [
                'options' => [
                    'class'       =>
                        $readonly==false ? 'input air-datepicker':'input',
                    'placeholder' => 'Выберете дату...',
                    'value'       => $passport->getDate('issued_date', 'd.m.Y'),
                    'readonly' => $readonly,
                ],
            ]);
			/*echo AirDatepicker::widget([
				'model'     => $passport,
				'attribute' => 'issued_date',
				'options'   => [
					'class' => 'input',
					'value' => $passport->getDate('issued_date', 'd.m.Y'),
				],
			]);*/
		} else {
			echo $form->field($passport, 'issued_date')->textInput([
				'class'    => 'input--main lk-form--input-sm',
				'value'    => $passport->getDate('issued_date', 'd.m.Y'),
				'readonly' => $readonly,
			])->label(false);
		}
		?>
	</div>
</div>

<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-set-p required"><?= Html::activeLabel($passport, 'division_code') ?></p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form__hidden-subt">
			<p class="lk-set-p required"><?= Html::activeLabel($passport, 'division_code') ?></p>
		</div>
		<?= $form->field($passport, 'division_code')->textInput([
			'class'    => 'input--main lk-form--input-sm subdivisionCodeMask',
			'readonly' => $readonly,
		])->label(false); ?>
	</div>
</div>

<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-set-p required"><?= Html::activeLabel($passport, 'place_of_birth') ?></p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form__hidden-subt">
			<p class="lk-set-p required"><?= Html::activeLabel($passport, 'place_of_birth') ?></p>
		</div>
		<?= $form->field($passport, 'place_of_birth')->textInput([
			'class'    => 'input--main lk-form--input-md',
			'readonly' => $readonly,
		])->label(false); ?>
	</div>
</div>

<div class="lk-form__row">
	<div class="lk-form__col-l">
		<p class="lk-set-p required"><?= Html::activeLabel($passport, 'place_of_residence') ?></p>
	</div>
	<div class="lk-form__col-r">
		<div class="lk-form__hidden-subt">
			<p class="lk-set-p required"><?= Html::activeLabel($passport, 'place_of_residence') ?></p>
		</div>
		<?= $form->field($passport, 'place_of_residence')->textarea([
			'class'    => 'textarea textarea--full',
			'cols'     => 30,
			'rows'     => 10,
			'readonly' => $readonly,
		])->label(false); ?>
	</div>
</div>
<?php $yes = true; if ($yes): ?>
<div class="lk-form__row">
	<div class="lk-form__col-l"></div>
	<div class="lk-form__col-r" style="position: relative;">
		<?php
		echo JQueryFileUpload::widget([
			//'id' => 'cover-image-input',
			'model'         => $passport,
			'attribute'     => 'scan_passport',
			'url'           => [''], // your route for saving images,
			'appearance'    => 'plus', // available values: 'ui','plus' or 'basic'
			'mainView'      => '@app/views/user/profile_update/scan_upload',
			//'options'       => ['accept' => 'image/*'],
			'clientOptions' => [
				'maxFileSize'      => 2000000,
				'dataType'         => 'json',
				'acceptFileTypes'  => new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
				'autoUpload'       => false,
				'previewMaxWidth'  => '400',
				'previewMaxHeight' => '400',
			],
			'clientEvents'  => [
				'add'  => "function (e, data) {
				    $('.__submit').prop('disabled', true);
				}",
			],
		]);

		$this->registerJs(<<<JS
		function previewFile() {
			var preview = document.querySelector('img.js-imgUpload--bg-img');
			var file    = document.querySelector('#userpassport-scan_passport').files[0];
			var reader  = new FileReader();
		    reader.addEventListener("load", function () {
			 	preview.src = reader.result;
		    }, false);
		
		    if (file) {
				reader.readAsDataURL(file);
		  	}
		}
JS
		);?>
		<label for="userpassport-scan_passport" style="
		width: 540px;
    cursor: pointer;
    height: 230px;
    background: #fff;
    opacity: 0;
    display: block;
    position: absolute;
    top: 0px;">Загрузить скан паспорта</label>
		<?= $form->field($passport, 'scan_passport')->fileInput(['style'=>'display:none;']) ?>
		<?php
		$js =<<<JS
				$('#userpassport-scan_passport').on('change', function(){
					//$('#w0').submit();
					previewFile();
					if($('img.js-imgUpload--bg-img').attr('src')==''){
						$('.js-imgUpload--bg').css('z-index',0);
						$('.js-imgUpload--bg').css('position','relative');
						$('.upbutton').show();
					}else{
						$('.js-imgUpload--bg').css('z-index',2);
						$('.js-imgUpload--bg').css('position','relative');
						$('.upbutton').hide();
					}
					
			  	});
JS;
		$this->registerJS($js);
		?> 		
	</div>
</div>
<?php else:
	$image = '';
	if(!empty($passport->scan_passport)){
		$image = 'src="'. $passport->getScanUrl().'"';
	}
	?>
	<div class="lk-form__row">
		<div class="lk-form__col-l"></div>
		<div class="lk-form__col-r" style="position: relative;">
			<div class="arg_i_add js-imgUpload--imglist">

				<div class="arg_i_add arg_i_add-1" style="padding: 0!important;">
					<div class="js-imgUpload--bg arg_i_add--bg" style="position: relative; <?php if(!empty($context->model->scan_passport)){ echo ' z-index: 2;';}?>" >
						<img class="js-imgUpload--bg-img" style="margin-bottom: 0;" alt="" <?=$image ?>>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif;?>
<!-- verify -->
<div style="display: none;">
	<div class="box-modal modal" id='verifyPopup'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title modal--delete">Пройти верификацию</h2>
			<div><p><br></p>
				<p>Вы даете согласие на проверку указанных вами данных. <br>После прохождения проверки вам будут доступны все функции сервиса Арендатика</p>
			</div>
			<div>
				<button type="button" class="verifySaveIt btn btn--next h-mrg-t-15">Пройти проверку</button>
				<div class="btn h-mrg-t-15 btn-pur arcticmodal-close" style="padding: 13px 52px;">Отказаться</div>
			</div>
		</div>
	</div>
</div>
<!-- end verify -->
<?php
$js =<<<JS
				$('.verifySaveIt').click(function(){
				    $('#user-verify_save').val(1);
					$('#w0').submit();
					$('#profile-form').submit();
				}); 
JS;
$this->registerJS($js);
?>