<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ExternalPlatforms as Platform;

/* @var $this yii\web\View */
/* @var $model app\models\ExternalPlatforms */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Площадки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-platforms-view">
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'service_id',
            'title',
            'feed_template:ntext',
                [
                'format' => 'raw',
                'attribute' => Platform::PARAMS_PRICE,
                'value' => $model->price,
            ],
                [
                'format' => 'raw',
                'attribute' => 'status',
                'value' => $model->getStatusLabels($model->status),
            ],
        ],
    ])
    ?>

</div>
