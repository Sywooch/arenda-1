<?php

use app\components\extend\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\components\extend\Url;
use app\components\widgets\SideHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RealEstateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Недвижимость';
$this->params['breadcrumbs'][] = $this->title;

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
	
	if(window.location.hash == '#create') {
	    $('.__create_estate').trigger('click');
	}
});
JS
);

?>

<?php Pjax::begin([
	'id' => 'real-estate-list',
]); ?>
<?=
ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView'     => 'index/_item',
	'layout'       => "{items}\n{pager}",
]);
?>
<?php Pjax::end(); ?>
<?php
echo $this->render('../user/profile/customer/_share_profile_lessor_modal', [
	'user'             => $user,
	'inviteCustomerForm' => $inviteCustomerForm,
	'realEstate'       => $realEstate,
]);?>

