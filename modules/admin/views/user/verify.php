<?php

use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Обновить данные верификация пользователя: [' . $model->user->fullName . ']';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->fullName, 'url' => ['view', 'id' => $model->user->id]];
$this->params['breadcrumbs'][] = 'Верификация';
?>
<div class="user-update">
    <?=
    $this->render('_form_verify', [
        'model' => $model,
    ])
    ?>
</div>
