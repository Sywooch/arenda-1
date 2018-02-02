<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Площадки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="side-help-view">
	<p>
		<?php echo Html::a('Превью', ['preview', 'id' => $model->id], ['class' => 'btn btn-info', 'target' => '_blank']) ?>
		<?php echo Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php echo Html::a('Удалить', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method'  => 'post',
			],
		]) ?>
	</p>
	
	<p>
	<?php echo Html::textInput('url', $model->getUrl(), ['readonly' => true, 'class' => 'form-control', 'onfocus' => 'this.select()']); ?>
	</p>

	<?php echo 
	DetailView::widget([
		'model'      => $model,
		'attributes' => [
			'code',
			'name',
			'standardPrice:text:Цена',
			'description',
			'enabled:boolean',
		],
	])
	?>
	
	<?php 
    /*
	* Раскомментировать этот блок и удалить standardPrice в случае потребности в вариативных ценовых условиях
    *
	<h3>Ценовые условия</h3>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Название</th>
				<th>Код</th>
				<th>Цена</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($model->prices as $price): ?>
				<tr>
					<td><?php echo Html::encode($price['label']); ?></td>
					<td><?php echo Html::encode($price['code']); ?></td>
					<td><?php echo Html::encode($price['price']); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	* */ ?>
	
	<h3>Шаблон</h3>
	<pre><code><?php echo Html::encode($model->header_template); ?></code></pre>
	<div style="height: 10px; line-height: 1px; font-size: 20px; margin-bottom: 10px;">...</div>
	<pre><code><?php echo Html::encode($model->item_template); ?></code></pre>
	<div style="height: 10px; line-height: 1px; font-size: 20px; margin-bottom: 10px;">...</div>
	<pre><code><?php echo Html::encode($model->footer_template); ?></code></pre>
</div>