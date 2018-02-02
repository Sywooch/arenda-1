<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\forms\ContactForm */

?>

<?php
$form = ActiveForm::begin([
    'id'                     => 'contact-form',
    'action'                 => Url::to(['/site/contacts']),
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'validateOnChange'       => true,
    'validateOnBlur'         => false,
    'validateOnSubmit'       => true,
    'options'                => [
        'class' => 'form form--shadow',
    ],
]);
?>
    <div class="form--title">
        <p>Написать нам</p>
    </div>

    <table class='form-table  form-table--pr'>
        <tr>
            <td>
                <p class="form--p">Представьтесь</p>
            </td>
            <td>
                <p class="form--p b-contacts__hidden-p">Представьтесь</p>
                <?=
                $form->field($model, 'name')->textInput([
                    'autofocus'   => true,
                    'class'=>'input input--full input--size-md input--border-g',
                    'placeholder' => 'Александр',
                ])->label(false);
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <p class="form--p">Ваш e-mail</p>
            </td>
            <td>
                <p class="form--p b-contacts__hidden-p">Ваш e-mail</p>
                <?=
                $form->field($model, 'email')->textInput([
                    'autofocus'   => true,
                    'class'=>'input input--full input--size-md input--border-g',
                    'placeholder' => 'mail@mail.com',
                ])->label(false);
                ?>
            </td>
        </tr>
        <tr>
            <td class='form--p-top'>
                <p class="form--p">Сообщение</p>
            </td>
            <td>
                <p class="form--p  b-contacts__hidden-p">Сообщение</p>
                <?=
                $form->field($model, 'body')->textarea([
                    'cols'=>30,
                    'rows'=>3,
                    'class'=>'textarea textarea--full  textarea--size-md',
                    'placeholder' => 'Cообщения',
                ])->label(false);
                ?>
            </td>
        </tr>
    </table>
    <div class="form__submit-wr">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-y btn-normal--s-sub']) ?>
    </div>
<?php ActiveForm::end(); ?>