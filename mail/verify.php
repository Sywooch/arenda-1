<?php
use app\components\helpers\CommonHelper;
use app\models\ScreeningRequest;
use app\components\extend\Html;
use yii\helpers\Url;
?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
    <tbody><tr>
        <td style="text-align: center;">
            Вы сделали запрос на верификацию данных на <a href="http://<?php echo CommonHelper::data()->getParam('tld', 'arenda.ru') ?>"><?php echo CommonHelper::data()->getParam('tld', 'arenda.ru') ?></a>.
            <br>Скоро мы проверим ваши данные и сообщим результат.
        </td>
    </tr>
    </tbody>
</table> 

