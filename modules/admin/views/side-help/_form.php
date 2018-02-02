<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\extend\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="side-help-form">

	<?php
	$form = ActiveForm::begin([
		'options' => [
			'enctype' => 'multipart/form-data',
		],
	]);
	?>

	<div class="row">
		<div class="col-md-8" style="overflow: scroll">
			<?=
			$form->field($model, 'content')->textarea([
				'class' => 'form-control content-textarea',
				'rows'  => 6,
			])
			?>
		</div>
	</div>

	<?= $form->field($model, 'url')->textInput() ?>

	<?= $form->field($model, 'status')->radioList($model->getStatusLabels()) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
