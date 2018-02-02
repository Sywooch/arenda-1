<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\extend\Url;

$this->title = 'Площадки';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Параметры договора аренды</h1>

<?php $form = ActiveForm::begin(['class' => 'kostyl-form', 'action' => URL::to('/admin/agreement/update')]); ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($config, 'agreement_fixed_part_change_notification')->textInput(['type' => 'number']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($config, 'agreement_days_to_transfer_object')->textInput(['type' => 'number']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($config, 'agreement_days_to_prolongation')->textInput(['type' => 'number']); ?>
    </div>
</div>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
<?php ActiveForm::end(); ?>
