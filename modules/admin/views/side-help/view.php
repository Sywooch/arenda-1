<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = $model->url;
$this->params['breadcrumbs'][] = ['label' => 'Боковые подсказки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$url = Url::to($model->url, true);

?>
<div class="side-help-view">
	<p>
		<?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?=
		Html::a('Удалить', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method'  => 'post',
			],
		])
		?>
	</p>

	<?=
	DetailView::widget([
		'model'      => $model,
		'attributes' => [
			'id',
			'content:html',
			[
				'attribute' => 'url',
				'format'    => 'raw',
				'value'     => Html::a($url, $url, ['target' => '_blank', 'class' => 'btn btn-link']),
			],
			[
				'attribute' => 'status',
				'value'     => $model->getStatusLabels($model->status),
			],
		],
	])
	?>

</div>