<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AdBoard;

?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php echo Html::hiddenInput('AdBoard[prices]', ''); ?>
	
    <?php echo $form->field($model, 'code')->textInput(); ?>
    <?php echo $form->field($model, 'name')->textInput(); ?>
    <?php echo $form->field($model, 'description')->textArea(); ?>
    
    <?php 
    /*
	* Раскомментировать этот блок и удалить блок ниже в случае потребности в вариативных ценовых условиях
    * 
    <div class="form-group <?php if ($model->hasErrors('prices')) echo 'has-error'; ?>">
		<div class="prices-header">
			<a href="#" class="btn btn-xs btn-info pull-right" id="add_price_cond">Добавить</a>
			<label class="control-label">Ценовые условия</label>
		</div>
		<div class="prices" id="prices_container">
			<?php if (!empty($model->prices)) foreach ($model->prices as $index => $price): ?>
				<div class="price-cond well" data-index="<?php echo $index; ?>">
					<div class="row">
						<div class="col-xs-4">
							<label class="control-label">Название</label>
							<input name="AdBoard[prices][<?php echo $index; ?>][label]" value="<?php echo Html::encode($price['label']); ?>" class="form-control" />
						</div>
						<div class="col-xs-3">
							<label class="control-label">Код</label>
							<input name="AdBoard[prices][<?php echo $index; ?>][code]" value="<?php echo Html::encode($price['code']); ?>" class="form-control" />
						</div>
						<div class="col-xs-3">
							<label class="control-label">Цена</label>
							<input name="AdBoard[prices][<?php echo $index; ?>][price]" value="<?php echo Html::encode($price['price']); ?>" class="form-control" />
						</div>
						<div class="col-xs-2">
							<a href="#" class="btn btn-xs btn-danger pull-right btn-remove">Убрать</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php echo Html::error($model, 'prices', ['class' => 'help-block']); ?>
	</div>
	*/ ?>
	<?php if (!empty($model->prices)) foreach ($model->prices as $index => $price): ?>
		<input name="AdBoard[prices][<?php echo $index; ?>][label]" type="hidden" value="<?php echo Html::encode($price['label']); ?>" />
		<input name="AdBoard[prices][<?php echo $index; ?>][code]" type="hidden" value="<?php echo Html::encode($price['code']); ?>" />
		<div class="form-group">
			<label class="control-label">Цена</label>
			<input name="AdBoard[prices][<?php echo $index; ?>][price]" value="<?php echo Html::encode($price['price']); ?>" class="form-control" />
		</div>
	<?php break; endforeach; ?>
	<?php // ?>
    
    <?php echo $form->field($model, 'header_template')->textArea(['rows' => 10]); ?>
    <?php echo $form->field($model, 'item_template')->textArea(['rows' => 30]); ?>
    <?php echo $form->field($model, 'footer_template')->textArea(['rows' => 10]); ?>
    <?php echo $form->field($model, 'enabled')->checkbox(); ?>
    <h3>Валидация</h3>
    <div class="form-group">
		<label class="control-label">Регион</label>
		<?php echo Html::dropdownList('AdBoard[validation][region]', $model->validation['region'], [
			AdBoard::VALIDATION_OPTIONAL => 'Опционально',
			AdBoard::VALIDATION_REQUIRED => 'Обязательно',
			AdBoard::VALIDATION_DICT_CIAN => 'Обязательно, проверка по справочнику CIAN',
		], ['class' => 'form-control'])?>
	</div>
	<div class="form-group">
		<label class="control-label">Город</label>
		<?php echo Html::dropdownList('AdBoard[validation][city]', $model->validation['city'], [
			AdBoard::VALIDATION_OPTIONAL => 'Опционально',
			AdBoard::VALIDATION_REQUIRED => 'Обязательно',
			AdBoard::VALIDATION_DICT_AVITO => 'Обязательно, проверка по справочнику AVITO',
		], ['class' => 'form-control'])?>
	</div>
	<div class="form-group">
		<label class="control-label">Район города</label>
		<?php echo Html::dropdownList('AdBoard[validation][district]', $model->validation['district'], [
			AdBoard::VALIDATION_OPTIONAL => 'Опционально',
			AdBoard::VALIDATION_REQUIRED => 'Обязательно',
			AdBoard::VALIDATION_DICT_AVITO => 'Обязательно, проверка по справочнику AVITO',
		], ['class' => 'form-control'])?>
	</div>
	<div class="form-group">
		<label class="control-label">Улица</label>
		<?php echo Html::dropdownList('AdBoard[validation][street]', $model->validation['street'], [
			AdBoard::VALIDATION_OPTIONAL => 'Опционально',
			AdBoard::VALIDATION_REQUIRED => 'Обязательно',
		], ['class' => 'form-control'])?>
	</div>
	<div class="form-group">
		<label class="control-label">Метро</label>
		<?php echo Html::dropdownList('AdBoard[validation][metro]', $model->validation['metro'], [
			AdBoard::VALIDATION_OPTIONAL => 'Опционально',
			AdBoard::VALIDATION_REQUIRED => 'Обязательно',
			AdBoard::VALIDATION_DICT_CIAN => 'Обязательно, проверка по справочнику CIAN',
		], ['class' => 'form-control'])?>
	</div>

    <div class="form-group">
		<?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>

<div id="price_cond_tmpl" style="display: none;">
	<div class="price-cond well" data-index="___INDEX___">
		<div class="row">
			<div class="col-xs-4">
				<label class="control-label">Название</label>
				<input name="AdBoard[prices][___INDEX___][label]" value="" class="form-control" />
			</div>
			<div class="col-xs-3">
				<label class="control-label">Код</label>
				<input name="AdBoard[prices][___INDEX___][code]" value="" class="form-control" />
			</div>
			<div class="col-xs-3">
				<label class="control-label">Цена</label>
				<input name="AdBoard[prices][___INDEX___][price]" value="" class="form-control" />
			</div>
			<div class="col-xs-2">
				<a href="#" class="btn btn-xs btn-danger pull-right btn-remove">Убрать</a>
			</div>
		</div>
	</div>
</div>

<?php $this->registerJs(
<<<ENDJS

$('#add_price_cond').on('click', function() {
	var cont = $('#prices_container');
	var index = 0;
	cont.children().each(function() {
		index = Math.max(index, 1 + 1 * $(this).attr('data-index'));
	});
	var html = $('#price_cond_tmpl').html().replace(/___INDEX___/g, index);
	cont.append(html);
	return false;
});
$('#prices_container').on('click', '.btn-remove', function() {
	$(this).closest('.price-cond').remove();
	return false;
});

ENDJS
);
