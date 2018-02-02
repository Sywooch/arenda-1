<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;

/* @var $this yii\web\View */
/* @var $sender \app\models\User */
/* @var $model app\models\forms\InviteLessorForm */
?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
	<tbody><tr>
		<td style="text-align: center;">
			<?= Html::tag('h1', 'Новое приглашение'); ?> 
		</td>
	</tr><tr>
		<td style="text-align: center;"><?php
			$text = '{user-profile} приглашает Вас  на <a href="{site-url}">{site-url}</a>. Ссылка на объявление <a href="{ad-url}">{ad-title}</a>';

			echo Html::tag('p', CommonHelper::str()->replaceTagsWithDatatValues($text, array_merge($sender->attributes, $model->attributes, [
					'user-profile' => Html::a($sender->fullName, $sender->getProfileUrl()),
					'site-url'     => Url::home(true),
					'ad-url'       => $ad->getUrl(true),
					'ad-title'     => $ad->estate->title,
				]
			)));

			?>
		</td>
	</tr>
	</tbody>
</table>