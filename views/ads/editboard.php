<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */

$this->title                   = 'Обновить : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Размещение на сайтах недвижимости';
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
            <p class="h2">Размещение на сайтах недвижимости</p>
        </div>
    </div>
    <div class="contant-row lk-edit--show">
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
                    <button type="button" class="btn btn--next js-modal-link confirmFeedPopup" data-id-modal="confirmFeedPopup">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>