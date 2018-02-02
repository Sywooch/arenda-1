<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Боковые подсказки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="side-help-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
