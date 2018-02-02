<?php

use app\components\extend\Html;
use app\components\extend\Url;

$contractUrl = Url::toRoute(['/lease-contracts/contract','id'=>$contract->id], true);

?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
	<tbody><tr>
		<td style="text-align: center;">
			<p>
				Вы были добавлены как участник в Договор найма квартиры, просим ознакомиться и подписать на сайте Аренда <a href="<?= $contractUrl ?>">Договор</a>.
			</p>
		</td>
	</tr>
	</tbody>
</table>


