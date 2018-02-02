<?php

use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RealEstate */

$this->title = 'Обновить: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Недвижимость', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="box-modal modal">
    <div class="modal__close box-modal_close arcticmodal-close"></div>
    <div class="modal__wr">
        <?= $this->render('_form', [
            'model' => $model,
            'estateUser' => $estateUser,
        ]) ?>
    </div>
</div>
