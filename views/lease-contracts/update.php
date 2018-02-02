<?php

use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LeaseContracts */

$this->title = 'Обновить договор аренды';
$this->params['breadcrumbs'][] = ['label' => 'Договоры аренды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="lease-contracts-update">

    <?= Html::tag('h1', Html::encode($this->title) . ' : &numero;' . $model->id); ?>
    <?=
    $this->render('_form', [
        'model' => $model,
        'realEstate' => $realEstate,
        'paymentMethods' => $paymentMethods,
    ])
    ?>

</div>