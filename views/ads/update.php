<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */

$this->title                   = 'Обновить : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<?php
$form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => false,
    'options'                => [
        'class' => '',
    ],
]);
?>
    <div class="title-row title-row--empty">
        <div class="title-row__title">
            <p class="h2">Общая информация</p>
        </div>
    </div>
    <div class="contant-row lk-edit--overfloy">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m lk-edit--overfloy">
            <?= $this->render('form/general_info', [
                'form'  => $form,
                'model' => $model,
            ]); ?>
        </div>
    </div>

    <div class="title-row title-row--empty js-drop-lk-edit">
        <div class="title-row__title">
            <p class="h2">О здании</p>
        </div>
    </div>
    <div class="contant-row lk-edit--hide">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m lk-edit--overfloy">
            <?= $this->render('form/building_info', [
            'form'  => $form,
            'model' => $model,
            ]); ?>
        </div>
    </div>
    <div class="title-row title-row--empty js-drop-lk-edit">
        <div class="title-row__title">
            <p class="h2">Укажите детали</p>
        </div>
    </div>
    <div class="contant-row lk-edit--hide">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m lk-edit--overfloy">
            <?= $this->render('form/details_info', [
                'form'  => $form,
                'model' => $model,
            ]); ?>
        </div>
    </div>
    <div class="title-row title-row--empty js-drop-lk-edit">
        <div class="title-row__title">
            <p class="h2">Информация об аренде</p>
        </div>
    </div>
    <div class="contant-row lk-edit--hide">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
            <?= $this->render('form/rent_info', [
                'form'  => $form,
                'model' => $model,
            ]); ?>
        </div>
    </div>
    <div class="title-row title-row--empty js-drop-lk-edit">
        <div class="title-row__title">
            <p class="h2">Обложка</p>
        </div>
    </div>
    <div class="contant-row lk-edit--hide">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
            <div class="form-param-1 ff js-imgUpload js-imgUpload_cover">
                <?= $this->render('form/cover', [
                    'form'  => $form,
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
    <div class="title-row title-row--empty js-drop-lk-edit">
        <div class="title-row__title">
            <p class="h2">Фотографии</p>
        </div>
    </div>
    <div class="contant-row lk-edit--hide">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
            <div class="form-param-1 ff js-imgUpload">
                <?= $this->render('form/photos', [
                    'form'  => $form,
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
    <div class="title-row title-row--empty js-drop-lk-edit">
        <div class="title-row__title">
            <p class="h2">Скрининг</p>
        </div>
    </div>
    <div class="contant-row lk-edit--hide">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
            <div class="form-param-1 ff">
                <?= $this->render('form/screening', [
                    'form'  => $form,
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
    <div class="title-row title-row--empty js-drop-lk-edit">
        <div class="title-row__title">
            <p class="h2">Размещение на сайтах недвижимости</p>
        </div>
    </div>
    <div class="contant-row lk-edit--hide">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
            <div class="form-param-1 ff">
                <?= $this->render('form/additional_options', [
                    'form'  => $form,
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
    <div class="contant-row">
        <div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
            <div class="lk-form__row h-mrg-b-0">
                <div class="lk-form__col-r">
                    <button type="submit" class="btn btn--next">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>