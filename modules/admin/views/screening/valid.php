<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Подтвердить отчет';
$this->params['breadcrumbs'][] = ['label' => 'Скрининг отчеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Подтвердить';
?>
<div class="screening-update">
    <div class="screening-form">
		<?php $form = ActiveForm::begin([
			'options'                => [
				'enctype' => 'multipart/form-data',
			],
		]); ?>
			<?php echo $form->field($model, 'document')->fileInput(); ?>
			<div class="form-group">
				<?php echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
