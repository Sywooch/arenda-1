<?php

use app\components\extend\Html;
use app\components\helper\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\forms\ContactForm */
?>

    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
        <tbody><tr>
            <td style="text-align: center;">
<?php
echo Html::tag('i', 'Имя: ' . $model->name) . Html::tag('br');
echo Html::tag('i', 'Эл. почта: ' . Html::a($model->email, 'mailto:' . $model->email));
echo '<hr/>';
//echo Html::tag('h4', $model->subject);
echo Html::tag('h4', 'Сообщения:');
echo Html::tag('p', $model->body); ?>
            </td>
        </tr> 
        </tbody>
    </table>
