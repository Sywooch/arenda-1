<?php

use app\components\extend\Html;
use yii\widgets\ListView;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ApplicationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $ad app\models\Ads */

$this->title = isset($ad->estate->title)?$ad->estate->title:'';

$this->registerJs(<<<JS
$(document).ready(function() {
	$(document).on('click', '.js-modal-link-ajax', function(e) {
	    e.preventDefault();
	    
	    var href = $(this).data('href');
	    
		$.arcticmodal({
		    type: 'ajax',
		    url: href,		   
		});
	});
});
JS
);

?>

<div class="lk-temp-apps2">
	<?=
	ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView'     => 'view_by_add/_item',
		'viewParams'   => [
			'isArchive' => $isArchive,
		],
	])
	?>
</div>
