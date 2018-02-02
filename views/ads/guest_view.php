<?php

use app\components\extend\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */

$this->title = $model->realEstate->getName() . ' - ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить объявление?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'real_estate_id',
                'format' => 'raw',
                'value' => $model->realEstate->renderCover([
                    'width' => 100,
                    'height' => 75,
                ]),
            ],
            'title',
            'description:ntext',
            'house_type',
            'accommodation_type',
            'number_of_bedrooms',
            'separate_bathroom',
            'combined_bathroom',
            'house_floors',
            'location_floor',
            'building_type',
            'number_of_rooms',
            'condition',
            [
                'attribute' => 'place_add_to',
                'value' => $model->getPlaceAddToList()
            ],
            'watch_statistics',
            'rent_cost_per_month',
            'rent_term',
            'rent_available_date',
            'rent_pledge',
            'check_credit_reports',
            'check_biographical_information',
        ],
    ])
    ?>

</div>
