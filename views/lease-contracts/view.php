<?php

use app\components\extend\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LeaseContracts */

$this->title = 'Просмотр договора аренды';
$this->params['breadcrumbs'][] = ['label' => 'Договоры аренды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lease-contracts-view">

    <?= Html::tag('h1', Html::encode($this->title) . ' : &numero;' . $model->id); ?>
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить пункт?',
                'method' => 'post',
            ],
        ])
        ?>
        <?= Html::a('История', ['rent-history', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
                [
                'attribute' => 'real_estate_id',
                'value' => $model->realEstate->name
            ],
                [
                'attribute' => 'price_per_month',
                'value' => $model->getPricePerMonth()
            ],
                [
                'attribute' => 'payment_date',
                'value' => $model->payment_date . '-го числа'
            ],
                [
                'attribute' => 'date_created',
                'value' => $model->getDate('date_created')
            ],
                [
                'attribute' => 'date_begin',
                'value' => $model->getDate('date_begin')
            ],
                [
                'attribute' => 'date_end',
                'value' => $model->getDate('date_end')
            ],
                [
                'attribute' => 'participants',
                'value' => $model->partParticipantsList(),
                'format' => 'raw'
            ],
        ],
    ])
    ?>

</div>
