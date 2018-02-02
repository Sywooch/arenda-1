<?php

use app\components\extend\Html;
use app\components\extend\Url;
use yii\bootstrap\ActiveForm;
use app\models\PaymentMethods;

$actionUrl = Url::to(['/ads/delete', 'id' => $model->id]);

$this->registerJs(<<<JS
    $('#item-delete-form').on('submit', function(e){       
        var form = $(this);
        
        $.ajax({
		  url: '{$actionUrl}',
		  method: 'POST',		
		  dataType: 'html'
		}).done(function( data ) {
		   $.pjax.reload({container:"#real-estate-list"});  //Reload ListView
		   $.arcticmodal('close');
		});
        
        return false;
    });
JS
);

?>
<div class="box-modal modal">
    <div class="modal__close box-modal_close arcticmodal-close"></div>
    <div class="modal__wr">
        <h2 class="modal__title modal--delete">Вы действительно хотите удалить выбранное объявление?</h2>
        <form id="item-delete-form" action="#!" class="madal-form modal-delete">
            <?= Html::submitButton('Да', ['class' => 'btn btn-y']) ?>
            <div class="btn btn-pur arcticmodal-close">Нет</div>
        </form>
    </div>
</div>
