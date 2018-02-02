<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LeaseContractsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Договоры аренды';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'leaser-contracts-list']); ?>
<?=
ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView'     => 'index/_item',
]);
?>
<?php Pjax::end(); ?>

