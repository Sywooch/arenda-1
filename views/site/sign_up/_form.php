<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\forms\SignupForm */


$f = $this->render('_f', ['model' => $model]);
$f2 = $this->render('_f', ['model' => $model]);
?>


<div class="registr-sect__head">
    <p class="registr-sect__h-title">
        Начните работу. Это бесплатно.
    </p>

    <p class="registr-sect__h-title registr-sect__h-title--2line">
        Начните работу.<br>Это бесплатно.
    </p>
    <p class="registr-sect__h-desc">
        Вы уже зарегистрированы? <a href="#!" data-id-modal="login" class="link link--crimson arcticmodal-close js-modal-link"><b>Войти.</b></a>
    </p>

</div>

<div class="h-mrg-t--20 ico-tabs ico-tabs--reg-form ico-tabs--ss-select js-tabs" id="reg-tab-in-section">

    <div class="ico-tabs__pre">

        <div class="ico-tabs__selector selector selector-color--m js-selector js-tab-selector" data-target-tabs="#reg-tab-in-section">
            <div class="selector__head js-selector-current-option-wrap">
                <span class="selector__option-current js-selector-current">Арендодатель</span>
                <span class="selector__option-icon"></span>
            </div>
            <ul class="selector__options-list js-selector-options">
                <li class="selector__option js-selector-option" data-option-name="0">
                    Хочу сдать
                </li>
                <li class="selector__option js-selector-option" data-option-name="0">
                    Хочу снять
                </li>
            </ul>
        </div>
    </div>

    <div class="ico-tabs__btns-wr">
        <div class="ico-tabs__btn-col">
            <div onclick="RegisterForm.asignRole($(this));" data-role="<?= User::ROLE_LESSOR ?>" class="<?= $model->role == User::ROLE_LESSOR ? '_active' : '' ?> ico-tabs__btn js-tabs-btn">
                <span class="ico-tabs__btn-inner">
                    <span class="ico-tabs__btn-img-wr">
                        <span class="icon icon--handshake"></span>
                    </span>
                    <span class="ico-tabs__btn-txt">
                       Хочу сдать
                    </span>
                </span>
            </div>
        </div>

        <div class="ico-tabs__btn-col">
            <div onclick="RegisterForm.asignRole($(this));" data-role="<?= User::ROLE_CUSTOMER ?>" class="<?= $model->role == User::ROLE_CUSTOMER ? '_active' : '' ?> ico-tabs__btn js-tabs-btn">
                <span class="ico-tabs__btn-inner">
                    <span class="ico-tabs__btn-img-wr">
                        <span class="icon icon--house-and-man"></span>
                    </span>
                    <span class="ico-tabs__btn-txt">
                        Хочу снять
                    </span>
                </span>
            </div>
        </div>
    </div>
    <div class="ico-tabs__body">
        <div class="tab _active  js-tabs-tab">
            <div class="ico-tabs__body-inner ">
                <?= $f; ?>
            </div>
        </div>
        <div class="tab js-tabs-tab">
            <div class="ico-tabs__body-inner ">
                <?= $f2; ?>
            </div>
        </div>
    </div>

</div>