<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExternalPlatforms */

$this->title = 'Добавить площадку';
$this->params['breadcrumbs'][] = ['label' => 'Площадки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-platforms-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
