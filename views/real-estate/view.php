<?php

use app\components\extend\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RealEstate */

$this->title = $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Недвижимость', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="real-estate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить ?',
                'method' => 'post',
            ],
        ])
        ?>
        <?= Html::a('Добавить объявление', ['/ads/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'city:ntext',
            'street:ntext',
            'total_area',
            'corps',
            'flat',
                [
                'attribute' => 'metro_id',
                'value' => $model->getMetroName()
            ],
                [
                'attribute' => 'cover_image',
                'value' => $model->renderCover([
                    'width' => 850,
                    'height' => 550,
                ]),
                'format' => 'raw'
            ],
        ],
    ])
    ?>

</div>
