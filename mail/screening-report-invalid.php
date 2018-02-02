<?php
use app\components\helpers\CommonHelper;
use app\models\ScreeningRequest;
use app\components\extend\Html;
?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
    <tbody><tr>
        <td style="text-align: center;">Ваши данные не прошли проверку на
            <a href="http://<?php echo CommonHelper::data()->getParam('tld', 'arenda.ru') ?>"><?php echo CommonHelper::data()->getParam('tld', 'arenda.ru') ?></a>:
            <?php echo $report->getTypeLabel() ?>.

            Комментарий администратора: <?php echo Html::encode($report->comment); ?>.
        </td>
    </tr>
    </tbody>
</table>
