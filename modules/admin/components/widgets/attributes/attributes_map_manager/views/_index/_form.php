<?php

use app\components\extend\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\components\extend\Url;
use app\models\AttributesMap;

/* @var $this yii\web\View */
/* @var $model app\models\AttributesMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attributes-map-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'AttributesMapForm',
                'enableClientValidation' => false,
                'options' => [
                    'onsubmit' => 'return false;'
                ]
    ]);
    ?>


    <?=
    $form->field($model, 'id', [
        'template' => '{input}'
    ])->hiddenInput([
        'onchange' => 'disableSelfParent($(this))'
    ])->label('')
    ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'label')->textInput() ?>
            <?= $form->field($model, 'hint')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'label_for_customers')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?=
            $form->field($model, 'input_type')->dropDownList($model->getInputTypesLabels(), [
                'class' => 'form-control',
                'onchange' => 'swithGroupWithDropDown($(this))',
                'data' => [
                    'group' => AttributesMap::INPUT_TYPE_RADIO,
                    'default' => AttributesMap::INPUT_TYPE_TEXT
                ]
            ])
            ?>
        </div>
        <div class="col-md-3">
            <?=
            $form->field($model, 'parent')->dropDownList(([0 => 'Корень'] + ArrayHelper::map($model->getAvailableParents(), 'id', 'labelWithGroup')), [
                'class' => 'form-control',
                'data' => [
                    'default' => 0
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 group-with-container" style="display: none">
            <?php
            $items = ArrayHelper::map($model->getAvailableGroupWith(), 'id', 'labelWithGroup');
            if ($items) {
                echo $form->field($model, 'group_with')->dropDownList($items, [
                    'class' => 'form-control'
                ]);
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'before')->textarea() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'after')->textarea() ?>
        </div>
    </div>
    <?=
    $form->field($model, 'show_to_customers')->dropDownList([
        1 => 'Да',
        0 => 'Нет'
    ])
    ?>


    <hr/>

    <div class="form-group">
        <?=
        Html::submitButton('OK', [
            'class' => ('saveAttributesMapFormModal ') . $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'onclick' => 'saveAttributesMapValues($(this));return false;',
            'data' => [
                'url' => Url::to(['/admin/attributes-map/save']),
                'form' => 'AttributesMapForm',
                'modal' => 'attributeMapManagerModal'
            ]
        ])
        ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
