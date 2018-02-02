<?php

use app\models\ScreeningReport;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = 'Скрининг отчет';
$this->params['breadcrumbs'][] = ['label' => 'Скрининг отчеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="pages-view">
	<?php if (!$model->isHandled()): ?>
		<p>
			<?php echo Html::a('Подтвердить', ['valid', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
			<?php echo Html::a('Отклонить', ['invalid', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
		</p>
	<?php endif; ?>
	
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
			'name_first',
			'name_last',
			'name_middle',
			'birthday:date', 
			'phone', 
			'address', 
			'post_code', 
			'insurance',
			[
				'attribute' => 'type',
				'value' => $model->getTypeLabel(),
			],
			[
				'attribute' => 'status',
				'value' => $model->getStatusLabel(),
			],
			[
				'attribute' => 'comment',
				'visible' => $model->status == ScreeningReport::STATUS_INVALID,
			],
			[
				'attribute' => 'document',
				'format' => 'raw',
				'visible' => $model->status == ScreeningReport::STATUS_VALID,
				'value' => Html::a('Скачать', $model->getDocumentUrl()),
			],
        ],
    ])
    ?>
</div>