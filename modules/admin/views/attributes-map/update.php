<?php

use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AttributesMap */

$this->title = 'Update Attributes Map: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Attributes Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="attributes-map-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
