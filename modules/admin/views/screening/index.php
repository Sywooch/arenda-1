<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\extend\Url;

$this->title = 'Скрининг отчеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">
    <?php echo 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-condensed'
        ],
        'columns' => [
			['class' => 'yii\grid\SerialColumn'],
            'name_first',
            'name_last',
            'name_middle',
            [
				'attribute' => 'type',
				'value' => function($model) {
					return $model->getTypeLabel();
				},
				'filter' => \app\models\ScreeningReport::getTypeLabels()
			],
			[
				'attribute' => 'status',
				'value' => function($model) {
					return $model->getStatusLabel();
				},
				'filter' => \app\models\ScreeningReport::getStatusLabels()
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'headerOptions' => ['style' => 'width: 70px;'],
				'template' => '{view} {valid} {invalid}',
				'buttons' => [
					'valid' => function($url, $model, $key) {
						return $model->isHandled() ? '' : Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
							'title' => 'Подтвердить',
						]);
					},
					'invalid' => function($url, $model, $key) {
						return $model->isHandled() ? '' : Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
							'title' => 'Отклонить',
						]);
					}
				]
			],
        ],
    ]);
    ?>
</div>
