<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;

$profileUrl = Url::toRoute(['/user/profile', 'id' => $contract->user->id], true);

?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
	<tbody><tr>
		<td style="text-align: center;">
			<p>
				Участник системы <?= $rasUser ?> отозвал(а) договор найма, который он/она вам направлял(-а) ранее. Пожалуйста,
				свяжитесь с <?= $rasUser ?> <a href="<?= $profileUrl; ?>"><?= $profileUrl; ?></a> для обсуждения причин.
			</p>
		</td>
	</tr>
	</tbody>
</table>
