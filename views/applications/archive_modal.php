<?php

use app\components\extend\Html;
use app\components\extend\Url;
use yii\bootstrap\ActiveForm;
use app\models\PaymentMethods;

$actionUrl = Url::to(['archive', 'id' => $model->id, 'refresh' => $refresh]);

$afterActionMessage = 'Заявка была успешно перемещена в Архив';

$this->registerJs(<<<JS
    $('#item-archive-form').on('submit', function(e){       
        var form = $(this);
        
        $.ajax({
		  url: '{$actionUrl}',
		  method: 'POST',		
		  dataType: 'html'
		}).done(function( data ) {
		   $.pjax.reload({container:"#__full-content-pjax-container"});  //Reload ListView
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
        <h2 class="modal__title modal--delete">Вы действительно хотите переместить выбранную заявку в Архив?</h2>
        <form id="item-archive-form" action="#!" class="madal-form modal-delete">
            <?= Html::submitButton('Да', ['class' => 'btn btn-y']) ?>
            <div class="btn btn-pur arcticmodal-close">Нет</div>
        </form>
    </div>
</div>
