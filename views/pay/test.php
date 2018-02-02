<?php
/**
 * Created by PhpStorm.
 * User: ivphpan
 * Date: 18.03.17
 * Time: 11:53
 * @var $this \yii\web\View
 * @var $pay \app\models\Pay
 * @var $inplatFormUrl
 */

$this->registerJsFile('https://demo-v-jet.inplat.ru/static/js/widget_tsp.js');
$js = <<<JS
window.InplatPaymentCallbacks = function (params) {
    if(params.event == 'successPayment'){
        console.log('Платёж успешно проведен!');
        console.log(params);
    }    
}
JS;
$this->registerJs($js);
?>
<?php if($inplatFormUrl):?>
 <a href="<?=$inplatFormUrl?>" class="inplat-pay" data-method="modal">Открыть демо-виджет</a>
<?php else:?>
 <p>Ошибка</p>
<?php endif?>

