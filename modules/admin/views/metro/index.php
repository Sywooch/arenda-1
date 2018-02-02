<?php

use app\components\extend\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MetroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Станции метро';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metro-index">
    <p>
        <?= Html::a('Добавить станцию метро', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <hr>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-condensed'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
