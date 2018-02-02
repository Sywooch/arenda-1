<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Отклонить отчет';
$this->params['breadcrumbs'][] = ['label' => 'Скрининг отчеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Отклонить';
?>
<div class="screening-update">
    <div class="screening-form">
		<?php $form = ActiveForm::begin(); ?>
			<?php echo $form->field($model, 'comment')->textArea(); ?>
			<div class="form-group">
				<?php echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
