<?php

/**
 * @var $model Ads
 * @var $this \yii\web\View
 */

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\Ads;
use app\models\AdBoard;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;
use yii\helpers\ArrayHelper;

$this->registerJsFile('https://demo-v-jet.inplat.ru/static/js/widget_tsp.js');
?>

<?php $boards = AdBoard::getAvailable(); ?>
<?php if (count($boards)): ?>
    <div class="lk-form__row">
        <div class="lk-form__col-l">
            <p class="lk-form--p-c">
                <?= Html::activeLabel($model, 'place_add_to'); ?>
            </p>
        </div>
        <div class="lk-form__col-r">
            <div class="Check_fam h4 Check_fam--line Check_fam--sq">
                <ol class="js-calc-cost">
                    <?= $form->field($model, 'place_add_to')->error(false)->checkboxList(ArrayHelper::map($boards, 'id',
                        'name'), [
                        'unselect' => false,
                        'item' => function ($index, $label, $name, $checked, $value) use ($boards, $model) {
                            $contents = [];
                            $contents[] = Html::beginTag('li');
                            $id = $name . '_' . $index;
                            $checkBoxParams =  [
                                'id' => $id,
                                'value' => $value,
                                'class' => 'js-checkbox',
                                'data-cost' => floatval($boards[$value]['std_price']),
                            ];

                            if($model->pay()->serviceIsPay($value)){
                                $checkBoxParams['disabled'] = 'disabled';
                                $checked = true;
                            }

                            $contents[] = Html::checkbox($name, $checked,$checkBoxParams);
                            $contents[] = Html::label(Html::tag('i', '', ['class' => 'Check_fam__view']) . $label, $id);
                            $contents[] = '<span class="price">' . floatval($boards[$value]['std_price']) . ' <span class="rub">Р</span></span>';
                            $contents[] = Html::endTag('li');
                            return implode("\n", $contents);
                        },
                    ])->hint(false); ?>
                </ol>
            </div>
            <br/>
            <?php if($model->pay()->statusNo()):?>
            <br/>
            <h4 class="js-cost-result result-box__t">Стоимость: <i class='js-cost'>0</i> <span class="rub">₽</span> в месяц</h4>
            <?php endif?>
            <p style="<?= $model->pay()->statusPaid() ? '' : 'display:none' ?>" class="js-pay-message"><?=$model->pay()->paidMessage()?></p>
            <a class="btn btn--next inplat-pay" data-object-id="<?= $model->id ?>" data-method="modal"
                    style="<?= !$model->pay()->statusNo() ? 'display:none' : '' ?>" data-pjax="0">Оплатить
            </a>
        </div>
    </div>
    <?php if ($model->hasErrors('place_add_to')): ?>
        <?= Html::error($model, 'place_add_to', ['tag' => 'p', 'class' => 'help-block help-block-error']) ?>
        <br/>
        <p>Пожалуйста, исправьте неточности в адресе, чтобы избежать проблем с публикацией объявлений на сторонних
            сервисах.</p>
        <br/>
        <?= $this->render('estate_address', [
            'form' => $form,
            'model' => $model->estate,
        ]); ?>
    <?php endif; ?>
<?php endif; ?>
<div class="lk-form__row">
    <div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'place_add_to'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
        <div class="Check_fam h4 Check_fam--line Check_fam--sq">
            <ol>
                <li>
                    <?= $form->field($model, 'watch_statistics', ['template' => '{input}{label}'])
                        ->checkbox([], false)
                        ->label(Html::tag('i', '',
                                ['class' => 'Check_fam__view']) . $model->getAttributeLabel('watch_statistics'))
                        ->error(false)
                        ->hint(false); ?>
                </li>
            </ol>
        </div>
        <?= Html::activeHint($model, 'watch_statistics', [
            'tag' => 'p',
            'class' => 'h-i-13',
        ]) ?>
    </div>
</div>

<style>
    .disabled{
        background: #ccc;
    }
</style>