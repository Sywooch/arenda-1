<?php

use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$link = Yii::$app->urlManager->createAbsoluteUrl([$resetLink, 'token' => $user->password_reset_token]);
$this->title = $subject;
?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
    <tbody><tr>
        <td style="text-align: center;"><?=
            Html::tag('p', 'Ссылка для восстановления пароля: ' . Html::a(Html::encode($link), $link));
            ?>
        </td>
    </tr>
    </tbody>
</table>
