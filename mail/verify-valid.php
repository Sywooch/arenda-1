<?php
use app\components\helpers\CommonHelper;
use app\models\ScreeningRequest;
use app\components\extend\Html;
?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
    <tbody><tr>
        <td style="text-align: center;">
            Вы успешно прошли верификацию на
            <a href="http://<?php echo CommonHelper::data()->getParam('tld', 'arenda.ru') ?>"><?php echo CommonHelper::data()->getParam('tld', 'arenda.ru') ?></a>
        </td>
    </tr>
    </tbody>
</table>
