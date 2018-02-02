<?php
use app\components\extend\Html;
use app\components\extend\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\components\widgets\SideHelper;
use app\models\PaymentMethods;

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

if (Yii::$app->controller->id == 'lease-contracts') {

	$this->registerJs(<<<JS
$(document).ready(function() {           
		var itsInput = $('.contract-payment_method_id');

        $(document).on('click', '[data-payment-way-choose-btn] span', function (e) {
            var allConts = $('[data-payment-way-gr]');
            var that = $(this),                
                itsParent = that.parents('[data-payment-way-gr]')
                   
            allConts.removeClass('_chosen-way');
            allConts.find('.state-btn__state--checked').hide();
            allConts.find('.state-btn__state--not-checked').css('display', 'block');
                        
            if (!that.hasClass('state-btn__state--checked')) {
	            itsParent.addClass('_chosen-way');
	            itsParent.find('.state-btn__state--checked').css('display', 'block');
	            itsParent.find('.state-btn__state--not-checked').hide();
	            itsInput.val(itsParent.data('payment-method-id'));
            } else {
                itsInput.val('');
            }
           
           	itsInput.closest('.form-group').find('.help-block-error').text('');
           
            e.stopPropagation();
        })
    
});
JS
	);

}

if (!isset($selectedMethodId)) {
	$selectedMethodId = null;
}

$this->registerJsFile('https://demo-v-jet.inplat.ru/static/js/widget_tsp.js');

$actionUrl = Url::to(['update-links']);

$js = <<<JS
window.InplatPaymentCallbacks = function (params) {
    //if(params.event == 'successPayment'){
        console.log('Платёж успешно проведен!');
        console.log(params);
    //}
       
    if(params.event == 'closePaymentModal'){
        $.ajax({
		  url: '{$actionUrl}',		 
		}).done(function( data ) {
		   $.pjax.reload({container:"#cards_and_bank_accounts"});  //Reload ListView   
		});       
    }        
}
JS;
$this->registerJs($js);
?>

<?php
Pjax::begin([
	'id' => 'cards_and_bank_accounts',
]);
?>
<p class="h-m-18">Банковские карты</p>
<?=
ListView::widget([
	'dataProvider' => $dataProviderCards,
	'itemView'     => 'index/_item',
	'emptyText'    => '',
	'layout'       => "{items}",
	'viewParams'   => [
		'selectedMethodId' => $selectedMethodId,
	],
]);
?>
<?php if ($dataProviderCards->totalCount == 0 && isset($inplatFormLinkUrl)): ?>
	<?=
	Html::a('Добавить карту', $inplatFormLinkUrl, [
		'class' => 'btn btn--add inplat-pay',
		'title' => 'Добавить карту',
		'data'  => [
			'method' => 'modal',
			'pjax'   => 0,
		],
	]);
	?>
	<div class="separator-l separator-l--m-30"></div>
	<?php else: ?>
	<br>
	<br>
<?php endif; ?>
<p class="h-m-18">Банковский счета</p>
<?=
ListView::widget([
	'dataProvider' => $dataProviderAccounts,
	'itemView'     => 'index/_item',
	'emptyText'    => '',
	'layout'       => "{items}",
	'viewParams'   => [
		'selectedMethodId' => $selectedMethodId,
	],
]);
?>
<?=
Html::button('Добавить счет', [
	'class' => 'btn btn--add js-modal-link-ajax',
	'title' => 'Добавить счет',
	'data'  => [
		'href' => Url::to(['/payment-methods/create', 'type' => PaymentMethods::TYPE_BANK_ACCOUNT]),
		'pjax' => 0,
	],
]);
?>
<?php Pjax::end(); ?>
