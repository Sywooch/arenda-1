<?php

use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Metro */

$this->title = 'Обновить станцию : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Станции метро', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="metro-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
