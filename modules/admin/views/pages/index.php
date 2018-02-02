<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">
    <p>
        <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <hr>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-condensed'
        ],
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'attribute' => 'image',
                'filter' => false,
                'format' => 'html',
                'value' => function($model) {
                    return $model->getFile('image')->renderImage([
                                'style' => 'width:100px'
                    ]);
                },
            ],
            'title',
//            'content:ntext',
            [
                'attribute' => 'url',
                'format' => 'html',
                'value' => function($model) {
                    return \app\components\extend\Url::to(['/' . $model->url], true);
                },
            ],
                [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabels($model->status);
                },
                'filter' => (new \app\models\Pages)->getStatusLabels()
            ],
                ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
