<?php
use app\components\extend\Html;

?>
<div class="lk-form__wr">
    <div class="lk-form__title">
        <p>Основная информация</p>
    </div>
    <?= $this->render('general_info', [
        'form'  => $form,
        'model' => $model,
    ]); ?>
</div>
<div class="separator-l"></div>
<div class="lk-form__wr">
    <div class="lk-form__title">
        <p>О здании</p>
    </div>
    <?= $this->render('building_info', [
        'form'  => $form,
        'model' => $model,
    ]); ?>
</div>
<div class="separator-l"></div>
<div class="submit-form-row submit-form-row--form-l">
    <?= Html::submitButton('Вперёд', ['class' => 'btn btn--next']) ?>
</div>
