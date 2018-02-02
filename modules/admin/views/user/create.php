<?php

use app\components\extend\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Добавить пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
