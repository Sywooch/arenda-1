<?php

use app\components\extend\Html;
use app\components\helper\Helper;
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

            $text = '{user-profile} приглашает Вас  на <a href="http://'.CommonHelper::data()->getParam('tld','arenda.ru').'">'.CommonHelper::data()->getParam('tld','arenda.ru').'</a>';
            ?>
            <?=

            Html::tag('p', CommonHelper::str()->replaceTagsWithDatatValues($text, array_merge(
                $sender->attributes, $model->attributes, [
                    'user-profile' => Html::a($sender->fullName, $sender->getProfileUrl())
                ]
            )))
            ?>
        </td>
    </tr>
    </tbody>
</table>


