<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body style="width: 100%; font-family: Arial, sans-serif">
    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 78px; border-bottom: 2px solid #ffc00f; width: 99%; text-align: center;">
        <tbody><tr>
            <td style="text-align: center;">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKMAAAAcCAYAAAAN8A8gAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjU3M0QyM0Y4RkRERTExRTY4QTMyODlFQkNBMjczOTU1IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjU3M0QyM0Y5RkRERTExRTY4QTMyODlFQkNBMjczOTU1Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NTczRDIzRjZGRERFMTFFNjhBMzI4OUVCQ0EyNzM5NTUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NTczRDIzRjdGRERFMTFFNjhBMzI4OUVCQ0EyNzM5NTUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6VHeJNAAALRElEQVR42uxc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&#10;" alt="arenda logo">
            </td>
        </tr>
        </tbody></table>
    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 99%; text-align: center; color: #39434d;">
        <tbody><tr>
            <td style="text-align: center; padding: 12px 0">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAYAAAAehFoBAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjcxQkVFOTRBRkRERTExRTY5QUE5QTk0QTE2MEFGMjVCIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjcxQkVFOTRCRkRERTExRTY5QUE5QTk0QTE2MEFGMjVCIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzFCRUU5NDhGRERFMTFFNjlBQTlBOTRBMTYwQUYyNUIiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzFCRUU5NDlGRERFMTFFNjlBQTlBOTRBMTYwQUYyNUIiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4so1rGAAADxklEQVR42syYW0hUQRjH1201iog0hCgpujzkQ2lhlLfShIggIssgpAejgoqsB7tq0oXUiijrobAbRRdK60mFKLUo1wqkJYkKeuj2ICkZVGxptP0H/gem5Zzdc5lz8IMfZziXOb+dnflm5iRcyljtixMZYBXIB+lgHM8PgDfgMbgLQj4bURZqtHR/IMa1RaAWZBtcn0AKwH7QCSrBI5+L4dc5Nwo0gA7KfgVnwXIwBYwESWAyEH/PefAd5PKZBtbhifB40A42gt/gACW3gGbwEQyCIfAJ3AGbKH8Y/OGz7azLVWHRKi1gAfjA1j0Ifpio5xuo5jOfWUezGy0tC9eD+eA9yLM5iLpBoSRd75awGDgbwC+wki+0G++YVYZYZ4EbwjUgAdTZTU9R8RwcZZ01qoUzpWxwQmHdJ9n/s/kOZcLFLN8yOcDMhmiA2ywXqxTOZ7nVYV1jwWnQy5QYBH95LV+VcIDTrYiXDupJBW1glnQuW5ol01W2cDLLvQpkRYaYA0aDPSDCe5LdyMMRBbKFzDJhZoltvC+JP0CJ8IC0mHEqG52/m6VyrQppIfya5XmKZX1Sn/7Cf9CxtJ/rWRFLFMuKWMqjWO1tVSHt5+JbxFppca5CdgzrFNGoStrPQRJkHt0RJ88+iCGbxMWOmDD6wT2QAh6CV6paWssSlaxkH5hrcO8RMDtGyx4H5UxhYi2cI9Upx3/SlzNLdtkRFq1wASSCJpCmc+8aHksMusE6HvO4+9DWyV0698rSdZBeZicPbwfPwFTuy7Ki7k3h8a1BXWEpn5vJ6UK6iiu6KjvCYe7bnoJp7NeHpIH4gsfNBnU18djJZ0Vci/P+U1Hpz/Kerg8s5sYywN2w2C5dlAbOMVCqU9dOcIYT0QDLFXHery07+51s88PcWN7kQBMLmPXS9RHgCsvXpfODHHTlJt89CVxl+YaK7xIdHOmZXM8uBDPZlxMNpK2EGKTT+UPPOfkuER0h7ogLuN4Q+Xav1NKlNoVFVuphfS3IFKmqhPWiToG06LdFlBaDrs2MtF1hVdJ9VqWdCCuRLgs1WpJ2KmxGOo1fkCaqkFYhrCddwW1SLqf9as6eaU6lVQlr0rtZp1gI/QRPpNQ1A9znEtW2tEphbRZcwS8/YX6nq6VsD/N4mxPpBBNf4FWF3qcALYIQzZVPUFK7X8gXiR/j93kXWst161zLMdvSXgpr0llcUmpYSXmtXgtbDklaRJaXfdgoIib7dMSNLGEngmb6tJnlpVd/uW5Lujk1exqB4Spm1NLDsYWDMa51/RNgANWVJ/fSZOnTAAAAAElFTkSuQmCC&#10;" alt="Key">
            </td>
        </tr> 
        </tbody></table>
        <?php $this->beginBody() ?>
        <?= $content; ?>
        <?php $this->endBody() ?>

    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 86px; border-top: 1px solid #d7d7d7; width: 99%; text-align: center;">
        <tbody><tr>
            <td style="text-align: center; color: #a6acb3; line-height: 25px;">
                Арендатика - это современная интернет платформа для собственников и нанимателей, упрощающая диалог добропорядочных нанимателей и проверенных собственников квартир, делающая весь процесс найма квартиры и последующее взаимодействие прозрачным, легким и удобным.
            </td>
        </tr>
        </tbody></table>

    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 86px; border-top: 1px solid #d7d7d7; width: 99%; text-align: center;">
        <tbody><tr>
            <td style="text-align: center; color: #a6acb3; line-height: 25px;">
                Если вы хотите отписаться от рассылки, перейдите по <a href="#" style="color: #9f3053;">ссылке</a>
                <br>
                Ваша <?=
                Html::a(Yii::$app->name, 'http://'.CommonHelper::data()->getParam('tld', 'arenda.ru'), [
                    'target'    => '_blank',
                    'style'     => 'color: #9f3053;'
                ])
                ?>
            </td>
        </tr>
        </tbody></table>

    </body>
</html>
<?php $this->endPage() ?>
