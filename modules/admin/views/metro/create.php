<?php

use app\components\extend\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Metro */

$this->title = 'Добавить станцию метро';
$this->params['breadcrumbs'][] = ['label' => 'Станции метро', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metro-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
