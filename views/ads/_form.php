<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\components\extend\FileInput;
use app\components\extend\Url;
use app\models\Ads;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-form img-polaroid">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
    ]);
    ?>

    <?= Html::tag('h2', 'Основная информация'); ?>
    <hr/>
    <?= $this->render('_form/_main_info', ['model' => $model, 'form' => $form]) ?>

    <?= Html::tag('h2', 'Детали'); ?>
    <hr/>
    <?= $this->render('_form/_details', ['model' => $model, 'form' => $form]) ?>

    <?= Html::tag('h2', 'Аренда'); ?>
    <hr/>
    <?= $this->render('_form/_rent', ['model' => $model, 'form' => $form]) ?>

    <?= Html::tag('h2', 'Фото'); ?>
    <hr/>
    <?= $this->render('_form/_images', ['model' => $model, 'form' => $form]); ?>

    <?= Html::tag('h2', 'Инструменты скрининга'); ?>
    <hr/>
    <?= $this->render('_form/_screening', ['model' => $model, 'form' => $form]) ?>

    <hr/>
    <?= $form->field($model, 'status')->radioList($model->getStatusLabels()); ?>
    <hr/>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
