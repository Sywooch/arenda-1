<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\extend\Url;

$this->title = 'Площадки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">
	<p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <hr>
    <?php echo 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-condensed'
        ],
        'columns' => [
			['class' => 'yii\grid\SerialColumn'],
            'code',
            'name',
			[
				'attribute' => 'enabled',
				'format' => 'boolean',
				'filter' => [1 => 'Да', 0 => 'Нет']
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'headerOptions' => ['style' => 'width: 70px;'],
			],
        ],
    ]);
    ?>
</div>
