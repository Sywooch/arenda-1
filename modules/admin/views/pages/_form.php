<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\extend\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
    ]);
    ?>

    <?=
    $form->field($model, 'image')->widget(FileInput::className(), [
        'options' => [
            'style' => '    height: 32px;'
        ]
    ])
    ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-md-8" style="overflow: scroll">
            <?=
            $form->field($model, 'content')->textarea([
                'class' => 'form-control content-textarea',
                'rows' => 6
            ])
            ?>
        </div>
        <div class="col-md-4">
            <label>Метки для вставки в XTML-код</label>
            <br/>
            <div class="text-muted">
                <input onclick="CommonHelper.insertValue('.content-textarea', $(this).val())" readonly="true" class="btn btn-info btn-xs" value="{signup_form}"> 
                - Форма регистрации
            </div>
            <div class="text-muted">
                <input onclick="CommonHelper.insertValue('.content-textarea', $(this).val())" readonly="true" class="btn btn-info btn-xs" value="{image_url}"> 
                - <?= $model->getAttributeLabel('image') ?> 
            </div>
            <div class="text-muted">
                <input onclick="CommonHelper.insertValue('.content-textarea', $(this).val())" readonly="true" class="btn btn-info btn-xs" value="{title}"> 
                - <?= $model->getAttributeLabel('title') ?> 
            </div>
        </div>
    </div>

    <?= $form->field($model, 'url')->textInput() ?>

        <?= $form->field($model, 'status')->radioList($model->getStatusLabels()) ?>

    <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
