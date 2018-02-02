<?php

use app\components\extend\Html;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\models\UserPassport;

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
			'class'    => 'input--main lk-form--input-md pasportMask',
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
			'class'    => 'input--main lk-form--input-md',
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
			echo AirDatepicker::widget([
				'model'     => $passport,
				'attribute' => 'issued_date',
				'options'   => [
					'class' => 'input',
					'value' => $passport->getDate('issued_date', 'd.m.Y'),
				],
			]);
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
<?php if (!$readonly): ?>
<div class="lk-form__row scans">
	<div class="lk-form__col-l"></div>
	<div class="lk-form__col-r">
		<?php if(!empty($passport->scan_passport)): ?>
			<?= Html::img($passport->getScanUrl(),['style'=>'max-width=100%']); ?>
			<br/>
		<?php endif;?>
		<?php if (empty($passport->request_id)): ?>
			<a href='#!' data-id-modal="verifyPopup" class="btn btn-lk-edit js-modal-link">Пройти верификацию</a>
		<?php elseif ($passport->verify==0): ?>
			<label class="btns btn-lk-edit">Запрос отправлен</label>
		<?php endif;?>
		
		<?php if(empty($passport->scan_passport)): ?>
			<label for="userpassport-scan_passport" class="btn btn-lk-edit">Загрузить скан паспорта</label>
			<?= $form->field($passport, 'scan_passport')->fileInput(['style'=>'display:none;']) ?>

			<?php
			$js = <<<JS
				$('#userpassport-scan_passport').on('change', function(){
					$('#w0').submit();
			  	});
JS;
			$this->registerJS($js);
			?>
		<?php elseif ($passport->verify==0): ?>
			<label for="userpassport-scan_passport" class="btn btn-lk-edit">Обновить скан паспорта</label>
			<?= $form->field($passport, 'scan_passport')->fileInput(['style'=>'display:none;']) ?>

			<?php
			$js = <<<JS
				$('#userpassport-scan_passport').on('change', function(){
					$('#w0').submit();
			  	});
JS;
			$this->registerJS($js);
			?>
			<a class="btn btn-lk-edit" href="?deletescan" onclick="return confirm('Вы уверен удалить скан паспорт?');" style="margin-left: auto; display: block; margin-right: 10px;">Удалить скан паспорта</a>
		<?php else: ?>
			<label class="btns btn-lk-edit">Верифицирован</label>
		<?php endif;?>
	</div>
</div>
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
					<a href="verify" class="btn btn--next h-mrg-t-15">Пройти проверку</a>
					<div class="btn h-mrg-t-15 btn-pur arcticmodal-close" style="padding: 13px 52px;">Отказаться</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end verify -->
<?php endif;?>