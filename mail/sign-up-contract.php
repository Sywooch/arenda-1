<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;

$siteUrl = 'http://' . CommonHelper::data()->getParam('tld', 'arenda.ru');
$contractUrl = $siteUrl . Url::to(['/lease-contracts/contract','id'=>$contract->id]);

?>

<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
	<tbody>
	<tr>
		<td style="text-align: center;">
			Отправляем вам логин и пароль от личного кабинета <b>Арендатики</b>
		</td>
	</tr>
	<tr>
		<td style="text-align: center;">
			Вы были добавлены как участник в Договор найма квартиры, просим ознакомиться и подписать на сайте Арендатика <a href="<?= $contractUrl ?>">Договор</a>.
		</td>
	</tr>
	<tr>
		<td style="text-align: center;">
			Арендатика - это современная интернет платформа для собственников и нанимателей, упрощающая диалог добропорядочных
			нанимателей и проверенных собственников квартир, делающая весь процесс найма квартиры и последующее взаимодействие
			прозрачным, легким и удобным.
		</td>
	</tr>
	</tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 99%; text-align: center; color: #39434d;">
	<tbody><tr>
		<td style="text-align: center; padding: 12px 0">
			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAYAAAAehFoBAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjcxQkVFOTRBRkRERTExRTY5QUE5QTk0QTE2MEFGMjVCIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjcxQkVFOTRCRkRERTExRTY5QUE5QTk0QTE2MEFGMjVCIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzFCRUU5NDhGRERFMTFFNjlBQTlBOTRBMTYwQUYyNUIiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzFCRUU5NDlGRERFMTFFNjlBQTlBOTRBMTYwQUYyNUIiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4so1rGAAADxklEQVR42syYW0hUQRjH1201iog0hCgpujzkQ2lhlLfShIggIssgpAejgoqsB7tq0oXUiijrobAbRRdK60mFKLUo1wqkJYkKeuj2ICkZVGxptP0H/gem5Zzdc5lz8IMfZziXOb+dnflm5iRcyljtixMZYBXIB+lgHM8PgDfgMbgLQj4bURZqtHR/IMa1RaAWZBtcn0AKwH7QCSrBI5+L4dc5Nwo0gA7KfgVnwXIwBYwESWAyEH/PefAd5PKZBtbhifB40A42gt/gACW3gGbwEQyCIfAJ3AGbKH8Y/OGz7azLVWHRKi1gAfjA1j0Ifpio5xuo5jOfWUezGy0tC9eD+eA9yLM5iLpBoSRd75awGDgbwC+wki+0G++YVYZYZ4EbwjUgAdTZTU9R8RwcZZ01qoUzpWxwQmHdJ9n/s/kOZcLFLN8yOcDMhmiA2ywXqxTOZ7nVYV1jwWnQy5QYBH95LV+VcIDTrYiXDupJBW1glnQuW5ol01W2cDLLvQpkRYaYA0aDPSDCe5LdyMMRBbKFzDJhZoltvC+JP0CJ8IC0mHEqG52/m6VyrQppIfya5XmKZX1Sn/7Cf9CxtJ/rWRFLFMuKWMqjWO1tVSHt5+JbxFppca5CdgzrFNGoStrPQRJkHt0RJ88+iCGbxMWOmDD6wT2QAh6CV6paWssSlaxkH5hrcO8RMDtGyx4H5UxhYi2cI9Upx3/SlzNLdtkRFq1wASSCJpCmc+8aHksMusE6HvO4+9DWyV0698rSdZBeZicPbwfPwFTuy7Ki7k3h8a1BXWEpn5vJ6UK6iiu6KjvCYe7bnoJp7NeHpIH4gsfNBnU18djJZ0Vci/P+U1Hpz/Kerg8s5sYywN2w2C5dlAbOMVCqU9dOcIYT0QDLFXHery07+51s88PcWN7kQBMLmPXS9RHgCsvXpfODHHTlJt89CVxl+YaK7xIdHOmZXM8uBDPZlxMNpK2EGKTT+UPPOfkuER0h7ogLuN4Q+Xav1NKlNoVFVuphfS3IFKmqhPWiToG06LdFlBaDrs2MtF1hVdJ9VqWdCCuRLgs1WpJ2KmxGOo1fkCaqkFYhrCddwW1SLqf9as6eaU6lVQlr0rtZp1gI/QRPpNQ1A9znEtW2tEphbRZcwS8/YX6nq6VsD/N4mxPpBBNf4FWF3qcALYIQzZVPUFK7X8gXiR/j93kXWst161zLMdvSXgpr0llcUmpYSXmtXgtbDklaRJaXfdgoIib7dMSNLGEngmb6tJnlpVd/uW5Lujk1exqB4Spm1NLDsYWDMa51/RNgANWVJ/fSZOnTAAAAAElFTkSuQmCC&#10;" alt="Key">
		</td>
	</tr>
	<tr>
		<td style="padding: 15px 0">
			<b>Логин:</b> <?= $user->email ?>
		</td>
	</tr>
	<tr>
		<td style="padding: 15px 0">
			<b>Пароль:</b> <?= $password; ?>
		</td>
	</tr>
	<tr>
		<td style="padding: 15px 0">
			<a href="http://<?php echo CommonHelper::data()->getParam('tld', 'arenda.ru'); ?>">
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMAAAAAwCAYAAABHTnUeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjBGOUE2MDA2RkRFMDExRTY5NTM4ODdGMUQ5RDE3Mzg3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjBGOUE2MDA3RkRFMDExRTY5NTM4ODdGMUQ5RDE3Mzg3Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MEY5QTYwMDRGREUwMTFFNjk1Mzg4N0YxRDlEMTczODciIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MEY5QTYwMDVGREUwMTFFNjk1Mzg4N0YxRDlEMTczODciLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6S7XiHAAAHLklEQVR42uxc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&#10;" alt="">
			</a>
		</td>
	</tr>
	</tbody>
</table>
