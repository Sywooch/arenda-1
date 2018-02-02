<?php

use app\components\extend\Html;
use yii\widgets\ListView;
use app\components\extend\Url;
use app\components\widgets\SideHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ApplicationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=
ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView'     => 'manager/_item',
])
?>


