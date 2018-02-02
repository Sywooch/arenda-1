<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\widgets\AirDatepicker\AirDatepicker;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\models\LeaseContracts;

?>
<div class="lk-form__wr">
    <div class="lk-form__title">
        <p>Оплата</p>
    </div>
    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">
                <?= Html::activeLabel($model, 'price_per_month'); ?>
            </p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form--inline">
                <?= $form->field($model, 'price_per_month')->textInput([
                    'class' => 'input--main lk-form--input-sm js-num-input-validate',
                ]);
                ?>
            </div>
            <div class="lk-form--inline">
                <div class="icon icon--ruble"></div>
            </div>
        </div>
    </div>
    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">
                <?= Html::activeLabel($model, 'payment_date'); ?>
            </p>
        </div>
        <div class="lk-form__col-r">
            <style>
                .js-selector-options{
                    overflow: auto;
                    height: 200px;
                }
            </style>
            <?= $form->field($model, 'payment_date')->widget(CustomDropdown::classname(), [
                'items' => LeaseContracts::getPaymentDayLabels(),
            ]);
            ?>
        </div>
    </div>
    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">
                <?= Html::activeLabel($model, 'cancellation_term'); ?>
            </p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form--inline">
                <?= $form->field($model, 'cancellation_term')
                         ->textInput([
                             'type'  => 'number',
                             'value' => 30,
                             'min'   => 30,
                             'class' => 'input--main lk-form--input-sm'
                         ]); ?>
            </div>
            <div class="lk-form--inline">
                дней
            </div>
        </div>
    </div>
</div>
<div class="separator-l"></div>
<div class="lk-form__wr">

    <div class="lk-form__title">
        <p>Расходы</p>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">Депозит</p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-form--p-c">Депозит</p>
            </div>
            <div class="Half_btn h4 Half_btn--big">
                <div class="Half_btn_con">
                    <label for="hk1" class="Half_btn__item<?= ($model->deposit_needed == 0) ? ' active' : ''; ?>">Не
                        требуется</label>
                    <label for="hk2" class="Half_btn__item<?= ($model->deposit_needed == 1) ? ' active' : ''; ?>">Требуется</label>
                </div>
                <i></i>
                <div class="Half_btn__hide">
                    <?php echo Html::activeRadio($model, 'deposit_needed',
                        ['id' => 'hk1', 'value' => 0, 'uncheck' => null]); ?>
                    <?php echo Html::activeRadio($model, 'deposit_needed',
                        ['id' => 'hk2', 'value' => 1, 'uncheck' => null, 'class' => 'reqDepozit_btn']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="lk-form__row reqDepozit_in" style="display: <?= ($model->deposit_needed == 0) ? 'none' : 'block'; ?>;">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">Сумма депозита</p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-form--p-c">Сумма депозита</p>
            </div>
            <div class="lk-form--inline">
                <?= $form->field($model, 'deposit_sum')->textInput([
                    'class' => 'input--main lk-form--input-s js-num-input-validate',
                ]);
                ?>
            </div>
            <div class="lk-form--inline">
                <div class="icon icon--ruble"></div>
            </div>
        </div>
    </div>

    <div class="lk-form__row reqDepozit_in" style="display: <?= ($model->deposit_needed == 0) ? 'none' : 'block'; ?>;">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">Дата оплаты депозита</p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-form--p-c">Дата оплаты депозита</p>
            </div>
            <?= $form->field($model, 'deposit_date_payed')->widget(AirDatepicker::classname(), [
                'options' => [
                    'class'       => 'input air-datepicker',
                    'placeholder' => 'Выберете дату...',
                    'value'       => $model->getDate('deposit_date_payed', 'd.m.Y'),
                ],
            ]);
            ?>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c-np">Коммунальные услуги</p>
            <p class="lk-form--p-sub lk-form--f-cursive">Расходы воды и электроэнергии по показаниям приборов учета</p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-form--p-c-np">Коммунальные услуги</p>
                <p class="lk-form--p-sub lk-form--f-cursive">Расходы воды и электроэнергии по показаниям приборов
                    учета</p>
            </div>
            <ul class="checkbox-row">
                <?= $form->field($model, 'bills_payed_by')->radioList(LeaseContracts::getBillsPayedByLabels(), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        
                        $contents = [];
                        
                        $contents[] = Html::beginTag('li');
                        $contents[] = Html::beginTag('div', ['class' => 'radiobtn']);
                        
                        $id         = $name . '_' . $index;
                        $contents[] = Html::radio($name, $checked, [
                            'id'    => $id,
                            'value' => $value,
                        ]);
                        $contents[] = Html::label(Html::tag('i', '', ['class' => 'Check_fam__view']) . $label, $id);
                        
                        $contents[] = Html::endTag('div');
                        $contents[] = Html::endTag('li');
                        
                        return implode("\n", $contents);
                    },
                ]) ?>
            </ul>
        </div>
    </div>

    <div class="lk-form__row js-lk-form-persent">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">Проценты оплаты жильцов (ами)</p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-form--p-c">Проценты оплаты жильцов (ами)</p>
            </div>
            <div class="lk-form--inline">
                <?= $form->field($model, 'bills_payed_percent')->textInput([
                    'class' => 'input--main lk-form--input-ss js-num-input-validate-persent',
                ]);
                ?>
            </div>
            <div class="lk-form--inline">
                %
            </div>
        </div>
    </div>

    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">Дополнительные расходы</p>
        </div>
        <div class="lk-form__col-r">
            <div class="lk-form__hidden-subt">
                <p class="lk-form--p-c">Дополнительные расходы</p>
            </div>
            <button class="btn btn--add js-show-toggle">+ Добавить еще</button>
            <p class="lk-form--f-cursive h-mrg-t-5">Добавьте любые другие расходы <br> помимо ежемесячной оплаты</p>
            <?php
            $additional_bills_options = [
                'class' => 'textarea textarea--full h-mrg-t-15 js-show-toggle--el',
                'cols'  => 30,
                'rows'  => 10,
            ];

            if (!empty($model->additional_bills)) {
                Html::addCssClass($additional_bills_options, '_active');
            }

            echo $form->field($model, 'additional_bills')->textarea($additional_bills_options);
            ?>
        </div>
    </div>

</div>
<div class="separator-l"></div>
<div class="submit-form-row--2">
    <div class="submit-form-row--2__link">
        <a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 1]) ?>" class="link link--prev-blue">
            Назад
        </a>
    </div>
    <div class="submit-form-row--2__btn">
        <?= Html::submitButton('Вперед', ['class' => 'btn btn--next']) ?>
    </div>
</div>
<?php
$this->registerJs(<<<JS
    $("#leasecontracts-price_per_month").change(function () {
        $("#leasecontracts-deposit_sum").val($("#leasecontracts-price_per_month").val());
    });
JS
);

?>
