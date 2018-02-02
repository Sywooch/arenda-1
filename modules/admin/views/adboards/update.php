<?php

use yii\helpers\Html;

$this->title = 'Обновление';
$this->params['breadcrumbs'][] = ['label' => 'Площадки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="pages-update">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
