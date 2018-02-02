<?php

use app\components\extend\Html;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\models\UserCustomerInfo;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $model app\models\UserCustomerInfo */
/* @var $form yii\widgets\ActiveForm */

$dataRHCC = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RENT_HISTORY_COUNTRY_CITY) : UserCustomerInfo::DATA_RENT_HISTORY_COUNTRY_CITY);
$dataRHSH = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RENT_HISTORY_STREET_HOUSE) : UserCustomerInfo::DATA_RENT_HISTORY_STREET_HOUSE);
$dataRHPB = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RENT_HISTORY_PERIOD_BGN) : UserCustomerInfo::DATA_RENT_HISTORY_PERIOD_BGN);
$dataRHPE = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RENT_HISTORY_PERIOD_END) : UserCustomerInfo::DATA_RENT_HISTORY_PERIOD_END);
$dataRHP = (isset($nameKey) ? str_replace("[1]", "[$nameKey]", UserCustomerInfo::DATA_RENT_HISTORY_PRICE) : UserCustomerInfo::DATA_RENT_HISTORY_PRICE);
?>

<div data-order-nr="<?= (int) @$nameKey; ?>"  data-compartment="<?= $dataRHCC; ?>"  class="js-user-profile-duplicate-fields js-user-profile-rent-history">
    <?= $this->render('_duplicate_header', ['nameKey' => @$nameKey]); ?>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RENT_HISTORY_COUNTRY_CITY) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RENT_HISTORY_COUNTRY_CITY) ?></p>
            </div>
            <?= Html::activeTextInput($model, 'data' . $dataRHCC, [
                'class' => 'input--main lk-form--input-md',
                'value' => $model->getDataValue($dataRHCC),
            ]); ?>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RENT_HISTORY_STREET_HOUSE) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RENT_HISTORY_STREET_HOUSE) ?></p>
            </div>
            <?= Html::activeTextInput($model, 'data' . $dataRHSH, [
                'class' => 'input--main lk-form--input-md',
                'value' => $model->getDataValue($dataRHSH),
            ]); ?>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RENT_HISTORY_PERIOD_BGN) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RENT_HISTORY_PERIOD_BGN) ?></p>
            </div>
            <div class="lk-form--inline">
                <div class="input--datepicker lk-form--datepicker-md js-datepicker is-active">
                    <?php
                    echo AirDatepicker::widget([
                        'model'       => $model,
                        'attribute'   => 'data' . $dataRHPB,
                        'options'     => [
                            'class' => 'input air-datepicker',
                            'placeholder' => 'Выберете дату...',
                            'value' => $model->getDataDate($dataRHPB),
                        ],
                        'addonAppend' => '<div class="input--datepicker__icon"></div>',
                    ]);
                    ?>
                </div>
            </div>
            <div class="lk-form--inline">
                <div class="input--datepicker lk-form--datepicker-md js-datepicker is-active">
                    <?php
                    echo AirDatepicker::widget([
                        'model'       => $model,
                        'attribute'   => 'data' . $dataRHPE,
                        'options'     => [
                            'class' => 'input air-datepicker',
                            'placeholder' => 'Выберете дату...',
                            'value' => $model->getDataDate($dataRHPE),
                        ],
                        'addonAppend' => '<div class="input--datepicker__icon"></div>',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RENT_HISTORY_PRICE) ?></p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-set-p required"><?= Html::activeDataLabel($model, UserCustomerInfo::DATA_RENT_HISTORY_PRICE) ?></p>
            </div>
            <?= Html::activeTextInput($model, 'data' . $dataRHP, [
                'class' => 'input--main lk-form--input-md',
                'value' => $model->getDataValue($dataRHP),
            ]); ?>
        </div>
    </div>

</div>

<?php
$data = $model->getDataValue(UserCustomerInfo::DATA_RENT_HISTORY_PERIOD_BGN, true);
if (!isset($nameKey) && is_array($data) && count($data) > 0) {
    foreach ($data as $key => $value) {
        if ($key == 1) {
            continue;
        }
        echo $this->render('_rent_history', [
            'model' => $model,
            'form' => $form,
            'nameKey' => $key,
        ]);
    }
}
?>