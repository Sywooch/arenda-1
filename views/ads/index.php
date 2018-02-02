<?php

use app\components\extend\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AdsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объявления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            'id',
                [
                'attribute' => 'real_estate_id',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->estate->renderCover([
                                'width' => 75
                    ]);
                }
            ],
            'title',
                [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabels($model->status);
                },
                'filter' => (new app\models\Ads())->getStatusLabels()
            ],
                [
                'header' => 'Новые заявки',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a('Просмотреть ' . $model->getApplicationsCount(), Url::to(['/applications/view-by-ad', 'id' => $model->primaryKey]), [
                                'data' => [
                                    'pjax' => 0
                                ]
                    ]);
                },
            ],
            // 'accommodation_type',
            // 'number_of_bedrooms',
            // 'separate_bathroom',
            // 'combined_bathroom',
            // 'house_floors',
            // 'location_floor',
            // 'building_type',
            // 'number_of_rooms',
            // 'condition',
            // 'place_add_to',
            // 'watch_statistics',
            // 'rent_cost_per_month',
            // 'rent_term',
            // 'rent_available_date',
            // 'rent_pledge',
            // 'check_credit_reports',
            // 'check_biographical_information',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
