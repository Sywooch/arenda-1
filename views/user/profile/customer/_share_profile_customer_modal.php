<?php
use app\models\User;
use yii\widgets\ActiveForm;
?>
<!-- shareProfile -->
<div style="display: none;">
    <div class="box-modal modal" id='shareProfile'>
        <div class="modal__close box-modal_close arcticmodal-close"></div>
        <div class="modal__wr">
            <h2 class="modal__title">Пригласить арендодателя</h2>
            <div class="modal__body">

                <?php if (isset($yes)): //$user->role == User::ROLE_CUSTOMER ?>
                    <div class="copy-link">
                        <input id="copy_text" type="text" value="<?= $user->getProfileUrl(); ?>">
                        <div class="copy-link__btn" data-clipboard-target="#copy_text">
                            <img src="/images/files-i.png" alt="">
                        </div>
                    </div>
                    <p class="sub sub--t">Вы можете скопировать и отправить ссылку на ваш профиль друзьям или разместить
                        на веб-сайтах. </p>
                <?php endif; ?>

                <?php
                $form = ActiveForm::begin([
                    'options'                => ['enctype' => 'multipart/form-data','class'=>'lk-form-popUp'],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => true,
                    'validateOnChange'       => true,
                    'validateOnBlur'         => false,
                    'validateOnSubmit'       => true,
                ]);
                ?>
                <h2>Пригласите ваших арендодателей лично!</h2>
                <?=
                $form->field($inviteLessorForm, 'fio')->textInput([
                    'placeholder' => 'ФИО',
                    'class' => 'input--main',
                ])->label(false);
                ?>
                <?=
                $form->field($inviteLessorForm, 'email')->textInput([
                    'placeholder' => 'E-mail',
                    'class' => 'input--main',
                ])->label(false);
                ?>
                <button type="submit" class="btn btn--next">Пригласить арендодателя</button>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
<!-- end shareProfile -->