<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\models\ScreeningReport;

$form = ActiveForm::begin([
	'enableAjaxValidation'   => true,
	'enableClientValidation' => true,
	'validateOnChange'       => true,
	'validateOnBlur'         => false,
	'validateOnSubmit'       => true,
]);

?>
	<style>.Check_fam--sq label:after, .Check_fam--sq .lab:after {
			top: 0px !important;
			left: -20px !important;
		}</style>
<div class="page-scrining">
	<div class="wpapper-con wrapper-con-2 js-calc-cost">
		<?php echo $form->field($model, 'type')->checkboxList([
			ScreeningReport::TYPE_CREDIT => ScreeningReport::TYPE_CREDIT,
			ScreeningReport::TYPE_BIO => ScreeningReport::TYPE_BIO,
		], [
			'style'	=> 'display: none;',
		])->label(false); ?>
		<div class="form-param-1 ff">
			<label for="cam21" class="block_rew block_rew--1 <?php echo isset($reports[ScreeningReport::TYPE_CREDIT]) ? 'disabled' : '' ?>">
				<span class="icon icon-calque"></span>
				<div class="Check_fam h4 Check_fam--big Check_fam--sq">
					<ol>
						<li class="topCheck">
							<?php if (!isset($reports[ScreeningReport::TYPE_CREDIT])): ?>
								<input id="cam21" name="ty2" type="checkbox" class='js-checkbox' data-cost='199' data-payed='0' onchange="$('#screeningreport-type input[value=<?php echo ScreeningReport::TYPE_CREDIT; ?>]').prop('checked', this.checked).trigger('change');" <?php if (is_array($model->type) && in_array(ScreeningReport::TYPE_CREDIT, $model->type)) echo 'checked="checked"'; ?>>
							<?php endif; ?>
							<p class="h-m-15 lab">Что такое проверка<br>кредитной истории</p>
						</li>
					</ol>
				</div>
				<p class="h4 h-bg-gray">
					Проверка вашей кредитной истории происходит онлайн на основании данных из нескольких российских баз кредитных историй. Вы и человек,  подавший вам данный запрос получите отчет вашей кредитной истории без указания данных о конкретных кредитах.
				</p>
				<a href="#">Образец<i class="icon icon-arr_r_up"></i></a>
			</label>
			<label for="cam22" class="block_rew block_rew--2 <?php echo isset($reports[ScreeningReport::TYPE_BIO]) ? 'disabled' : '' ?>">
				<span class="icon icon-loup"></span>
				<div class="Check_fam h4 Check_fam--big Check_fam--sq">
					<ol>
						<li class="topCheck">
							<?php if (!isset($reports[ScreeningReport::TYPE_BIO])): ?>
								<input id="cam22" name="ty3" type="checkbox" class='js-checkbox' data-cost='199' data-payed='0'  onchange="$('#screeningreport-type input[value=<?php echo ScreeningReport::TYPE_BIO; ?>]').prop('checked', this.checked).trigger('change');" <?php if (is_array($model->type) && in_array(ScreeningReport::TYPE_BIO, $model->type)) echo 'checked="checked"'; ?>>
							<?php endif; ?>
							<p class="h-m-15 lab">Что такое проверка<br>личных данных</p>
						</li>
					</ol>
				</div>
				<p class="h4 h-bg-gray">
					Проверка личных данных осуществляется онлайн через базы данных из Федеральной Миграционной Службы, (ФМС), Федеральной Службы Судебных Приставов (ФССП), Федеральной Налоговой Службы (ФНС) и прочих баз данных.  Вы и человек, подавший вам данный запрос получите информацию о действительности вашего паспорта, его прописке и об отсутствии судебных исков.
				</p>
				<a href="#">Образец<i class="icon icon-arr_r_up"></i></a>
			</label>
		   
		</div>
	</div>
	<div class="separator-l separator-l--m-t"></div>
	<div class="result-box">
		<h2 class="result-box__t ">Стоимость: <i class='js-cost'>0</i> рублей<br>(299 рублей в случае двух отчетов)</h2>
		<h2 class="result-box__b">Оплата отчетов будет списана с вашей карты</h2>
	</div>
	<div class="separator-l"></div>
	<div class="lk-scrining-form lk-form lk-form--row-3-7 lk-form--row-p-20">
		<div class="lk-form__wr ">
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?php echo $model->getAttributeLabel('name_last'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'><?php echo $model->getAttributeLabel('name_last'); ?></p>  
					</div>
					<?php echo $form->field($model, 'name_last')->textInput([
						'class'       => 'input--main lk-form--input-md',
					])->label(false); ?>
				</div>
			</div>
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?php echo $model->getAttributeLabel('name_first'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'><?php echo $model->getAttributeLabel('name_first'); ?></p>  
					</div>
					<?php echo $form->field($model, 'name_first')->textInput([
						'class'       => 'input--main lk-form--input-md',
					])->label(false); ?>
				</div>
			</div>
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?php echo $model->getAttributeLabel('name_middle'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'><?php echo $model->getAttributeLabel('name_middle'); ?></p>  
					</div>
					<?php echo $form->field($model, 'name_middle')->textInput([
						'class'       => 'input--main lk-form--input-md',
					])->label(false); ?>
				</div>
			</div>
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?php echo $model->getAttributeLabel('birthday'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'><?php echo $model->getAttributeLabel('birthday'); ?></p>  
					</div>
					<?php echo $form->field($model, 'birthday')->widget(AirDatepicker::classname(), [
						'options' => [
							'class'       => 'input--main lk-form--input-sm air-datepicker',
							'placeholder' => 'Выберете дату...',
							'value'       => $model->getDate('birthday', 'd.m.Y'),
						],
					]); ?>
				</div>
			</div>
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?php echo $model->getAttributeLabel('phone'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'><?php echo $model->getAttributeLabel('phone'); ?></p>  
					</div>
					<?php echo $form->field($model, 'phone')->textInput([
						'class'       => 'input--main lk-form--input-sm phoneMask',
					])->label(false); ?>
				</div>
			</div>
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?php echo $model->getAttributeLabel('address'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'><?php echo $model->getAttributeLabel('address'); ?></p>  
					</div>
					<?php echo $form->field($model, 'address')->textInput([
						'class'       => 'input--main lk-form--input-md',
					])->label(false); ?>
				</div>
			</div> 
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?php echo $model->getAttributeLabel('post_code'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'><?php echo $model->getAttributeLabel('post_code'); ?></p>  
					</div>
					<?php echo $form->field($model, 'post_code')->textInput([
						'class'       => 'input--main lk-form--input-sm mailIndex',
					])->label(false); ?>
				</div>
			</div>
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?php echo $model->getAttributeLabel('insurance'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'><?php echo $model->getAttributeLabel('insurance'); ?></p>  
					</div>
					<?php echo $form->field($model, 'insurance')->textInput([
						'class'       => 'input--main lk-form--input-sm polisMask',
					])->label(false); ?>
				</div>
			</div>
			<div class="lk-form__row">
				<div class="lk-form__col-l"></div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class='lk-form--p-c'></p>  
					</div>
					<div class="checkbox h-mrg-t-5">
						<?php 
							$field = $form->field($model, 'accept_terms')->checkbox(['uncheck' => ''])->label(false); 
							$field->template = '{error} {input} <label for="screeningreport-accept_terms">Подтверждаю согласие с <a href="#">правилами</a> обработки данных</label>';
							echo $field; 
						?>
					</div>                                        
				</div>
			</div>
			<div class="separator-l"></div>
			<div class="lk-form__row h-mrg-b-0">
				<div class="lk-form__col-r _w100--sc860">
					<button type='submit' id="doItCheck" class="btn btn--next">Далее</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$js =<<<JS
				 
	$('#w0').on('submit', function() {
		if(!$('#w0 .form-group').hasClass('has-error')){
			$('#doItCheck').prop('disabled', true);
		}
	}); 
	$('.lk-form__row').hover(
	function(){ 
		if($('#w0 .form-group').hasClass('has-error')){
			$('#doItCheck').prop('disabled', true);
		}
		if(!$('#w0 .form-group').hasClass('has-error')){
			$('#doItCheck').prop('disabled', false);
		}
	},
	function(){ 
	
	});
	
JS;
$this->registerJS($js);
?>
<?php ActiveForm::end(); ?>