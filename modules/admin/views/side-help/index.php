<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Боковые подсказки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="side-help-index">
	<p>
		<?= Html::a('Добавить Боковую подсказку', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<hr>
	<?=
	GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'tableOptions' => [
			'class' => 'table table-striped table-condensed'
		],
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'url',
				'format'    => 'html',
				'value'     => function ($model) {
					return \app\components\extend\Url::to(['/' . $model->url], true);
				},
			],
			[
				'attribute' => 'status',
				'value'     => function ($model) {
					return $model->getStatusLabels($model->status);
				},
				'filter'    => (new \app\models\Pages)->getStatusLabels(),
			],
			['class' => 'yii\grid\ActionColumn'],
		],
	]);
	?>
</div>
