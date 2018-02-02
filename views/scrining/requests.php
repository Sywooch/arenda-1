<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Проверка данных';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin([
	'id' => 'screening-requests-list',
	'linkSelector' => 'a:not(.document)',
]); ?>
<?php echo ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView'     => 'request_item',
	'layout'       => "{items}\n{pager}",
	'emptyText'		=> 'Вы пока не делали 
запросы на проверку ваших потенциальных или текущих нанимателей',
]);
?>
<?php Pjax::end(); ?>