<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ExternalPlatforms;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ExternalPlatformsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Площадки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-platforms-index">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-condensed'
        ],
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            'service_id',
            'title',
            //'feed_template:ntext',
            //'params',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabels($model->status);
                },
                'filter' => (new ExternalPlatforms())->getStatusLabels()
            ],
                [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view}'
            ],
        ],
    ]);
    ?>
</div>
