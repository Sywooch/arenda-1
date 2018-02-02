<?php

use app\components\extend\Html;
use app\components\extend\Url;

$contractUrl = Url::toRoute(['/lease-contracts/contract','id'=>$contract->id], true);

?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
	<tbody><tr>
		<td style="text-align: center;">
			<p>
				Cобственник внес изменения в договор №<?php echo $contract->id; ?>. Вам нужно <a href="<?= $contractUrl ?>">подписать</a> его заново на сайте Аренда.
			</p>
		</td>
	</tr>
	</tbody>
</table>


