<?php

use app\components\extend\Modal;
use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExternalPlatforms */
/* @var $form yii\widgets\ActiveForm */

$label = $model->getAttributeLabel('feed_template');
?>

<?= Html::tag('label', $label); ?>

<br/>

<?php
$mid = 'platformTemplateModal';
echo Html::a('Шаблон', '#', [
    'onclick' => "$('#$mid').modal('show');return false;",
    'class' => 'btn btn-sm btn-default'
]);
Modal::begin([
    'id' => $mid,
    'size' => Modal::SIZE_LARGE,
    'header' => null,
]);
?>

<div class="row">
    <div class="col-md-8">
        <?= $form->field($model, 'feed_template')->textarea(['rows' => 40]) ?>
    </div>
    <div class="col-md-4">
        <!--/* TODO #PS: INTEGRATION(platforms) add available attributes for XML template */-->
    </div>
</div>

<?=
Html::a('Готово', '#', [
    'onclick' => "$('#$mid').modal('hide');return false;",
    'class' => 'btn btn-sm btn-success'
]);
?>
<?php
Modal::end();
?>