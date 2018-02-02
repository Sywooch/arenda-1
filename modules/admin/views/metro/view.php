<?php

use app\components\extend\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Metro */

$this->title = 'Просмотр станции метро';
$this->params['breadcrumbs'][] = ['label' => 'Станции метро', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metro-view">
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
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name:ntext',
        ],
    ])
    ?>

</div>
