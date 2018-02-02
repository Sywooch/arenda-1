<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = 'Обновить Боковую подсказку: ' . $model->url;
$this->params['breadcrumbs'][] = ['label' => 'Боковые подсказки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->url, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="side-help-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
