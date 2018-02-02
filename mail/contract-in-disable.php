<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;

$disableDate = date('d.m.Y', strtotime("+30 days"));
$link = '<a href="http://'.CommonHelper::data()->getParam('tld','arenda.ru').'/lease-contract/contract?id='.$dogId.'">расторгнуть договор</a>';
?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
    <tbody><tr>
        <td style="text-align: center;">
            <?php if($isOwner){?>
                <p>Ваш договор №<?= $dogId ?> будет расторгнут <?= $disableDate ?>.</p>
            <?php }else{ ?>
                <p>Жилец <?= $rasUser ?> намерен <?= $link ?>, заключенный на <?=CommonHelper::data()->getParam('tld',
                        'arenda.ru')?>. Договор будет расторгнут <?= $disableDate ?>.</p>
            <?php } ?>
        </td>
    </tr>
    </tbody>
</table>
