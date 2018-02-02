<?php

use app\components\extend\Html;
use app\components\extend\DatePicker;
use app\models\UserCustomerInfo;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $model app\models\UserCustomerInfo */
/* @var $form yii\widgets\ActiveForm */

$dataRFN = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RECOMMEND_FIRST_N) : UserCustomerInfo::DATA_RECOMMEND_FIRST_N);
$dataRLN = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RECOMMEND_LAST_N) : UserCustomerInfo::DATA_RECOMMEND_LAST_N);
$dataRP = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RECOMMEND_PHONE) : UserCustomerInfo::DATA_RECOMMEND_PHONE);
$dataRE = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RECOMMEND_EMAIL) : UserCustomerInfo::DATA_RECOMMEND_EMAIL);
$dataRR = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RECOMMEND_RELATION) : UserCustomerInfo::DATA_RECOMMEND_RELATION);
?>


<div data-order-nr="<?= (int) @$nameKey; ?>"  data-compartment="<?= $dataRFN; ?>"  class="js-user-profile-duplicate-fields js-user-profile-recommendations">
    <?= $this->render('_duplicate_header', ['nameKey' => @$nameKey]); ?>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_FIRST_N) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_FIRST_N) ?></p>
            </div>
            <?= Html::activeTextInput($model, 'data' . $dataRFN, [
                'class' => 'input--main lk-form--input-md',
                'value' => $model->getDataValue($dataRFN),
            ]); ?>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_LAST_N) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_LAST_N) ?></p>
            </div>
            <?= Html::activeTextInput($model, 'data' . $dataRLN, [
                'class' => 'input--main lk-form--input-md',
                'value' => $model->getDataValue($dataRLN),
            ]); ?>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_PHONE) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_PHONE) ?></p>
            </div>
            <?= Html::activeTextInput($model, 'data' . $dataRP, [
                'class' => 'input--main lk-form--input-md',
                'value' => $model->getDataValue($dataRP),
            ]); ?>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_EMAIL) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_EMAIL) ?></p>
            </div>
            <?= Html::activeTextInput($model, 'data' . $dataRE, [
                'class' => 'input--main lk-form--input-md',
                'value' => $model->getDataValue($dataRE),
            ]); ?>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_RELATION) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RECOMMEND_RELATION) ?></p>
            </div>
            <div class="selector lk-form--select-md selector-color--m js-selector">
                <div class="selector__head js-selector-current-option-wrap">
                    <input type="hidden" name="demo[count_contacts]" class="js-selector-current-val">
                    <span class="selector__option-current js-selector-current">Дружеские</span>
                    <span class="selector__option-icon"></span>
                </div>
                <ul class="selector__options-list js-selector-options" style="display: none;">
                    <li class="selector__option js-selector-option">
                        Дружеские
                    </li>
                    <li class="selector__option js-selector-option">
                        обект 2
                    </li>
                    <li class="selector__option js-selector-option">
                        обект 3
                    </li>
                    <li class="selector__option js-selector-option">
                        обект 4
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>



<?php
$data = $model->getDataValue(UserCustomerInfo::DATA_RECOMMEND_FIRST_N, true);
if (!isset($nameKey) && is_array($data) && count($data) > 0) {
    foreach ($data as $key => $value) {
        if ($key == 1) {
            continue;
        }
        echo $this->render('_recommendations', [
            'model' => $model,
            'form' => $form,
            'nameKey' => $key,
        ]);
    }
}
?>