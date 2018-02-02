<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExternalPlatforms */

$this->title = 'Обновить данные площадки: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Площадки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="external-platforms-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
