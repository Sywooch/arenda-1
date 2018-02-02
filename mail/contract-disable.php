<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;

?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
    <tbody><tr>
        <td style="text-align: center;">
            <p>Участник системы <?= $rasUser ?> расторгнул(а) Ваш договор №<?= $dogId ?> на <?=CommonHelper::data()->getParam('tld',
                    'arenda.ru')?> </p>
        </td>
    </tr>
    </tbody>
</table>
