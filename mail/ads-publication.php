<?php

use app\components\extend\Html;
use app\components\extend\Url;


?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
	<tbody><tr>
		<td style="text-align: center; padding: 0 25%;">
			<p>
                Вы подтвердили размещение вашего объекта на площадках недвижимости: <?php echo $boards; ?> сроком до <?php echo date('d.m.Y',$user->feed_free_date); ?>.
			</p>
		</td>
	</tr>
	</tbody>
</table>


