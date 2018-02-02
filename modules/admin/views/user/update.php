<?php

use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Обновить данные пользователя: [' . $model->fullName . ']';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="user-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
