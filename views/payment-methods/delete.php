<?php

use app\components\extend\Html;
use app\components\extend\Url;
use yii\bootstrap\ActiveForm;
use app\models\PaymentMethods;

$actionUrl = Url::to(['delete', 'id' => $model->id]);

if ($model->type == PaymentMethods::TYPE_CARD) {
    $actionMessage = 'Вы действительно хотите удалить выбранную карту?';
} else {
    $actionMessage = 'Вы действительно хотите удалить выбранный счёт?';
}

if ($model->type == PaymentMethods::TYPE_CARD) {
    $afterActionMessage = 'Карта была успешно удалена';
} else {
    $afterActionMessage = 'Счёт был успешно удален';
}

$this->registerJs(<<<JS
    $('#item-delete-form').on('submit', function(e){       
        var form = $(this);
        
        $.ajax({
		  url: '{$actionUrl}',
		  method: 'POST',		
		  dataType: 'html'
		}).done(function( data ) {
		   $.pjax.reload({container:"#cards_and_bank_accounts"});  //Reload ListView
		   $.arcticmodal('close');
		   $('#_modal-message-text').text('{$afterActionMessage}');
		   $('#_modal-message').arcticmodal();  
		});
        
        return false;
    });
JS
);

?>
<div class="box-modal modal">
    <div class="modal__close box-modal_close arcticmodal-close"></div>
    <div class="modal__wr">
        <h2 class="modal__title modal--delete"><?= $actionMessage ?></h2>
        <form id="item-delete-form" action="#!" class="madal-form modal-delete">
            <?= Html::submitButton('Да', ['class' => 'btn btn-y']) ?>
            <div class="btn btn-pur arcticmodal-close">Нет</div>
        </form>
    </div>
</div>
