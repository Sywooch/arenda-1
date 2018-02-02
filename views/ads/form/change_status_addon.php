<?php
use app\models\Ads;
use app\components\extend\Html;
use app\components\extend\Url;

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

<?php if ($model->status == Ads::STATUS_DISABLED) {
	echo Html::button('Активировать объявление', [
		'class' => 'btn btn-y btn-normal lk-temp__button_y js-modal-link-ajax',
		'title' => 'Активировать объявление',
		'data'  => [
			'href' => Url::to(['change-status', 'id' => $model->primaryKey]),
			'pjax' => 0,
		],
	]);
} else {
	echo Html::button('Снять/Приостановить', [
		'class' => 'btn btn-gr btn-normal lk-temp__button_y js-modal-link-ajax',
		'title' => 'При снятии объявления размещение на всех сайтах недвижимости также будет приостановлено',
		'data'  => [
			'href' => Url::to(['change-status', 'id' => $model->primaryKey]),
			'pjax' => 0,
		],
	]);
}

?>