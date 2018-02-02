<?php

use app\components\extend\Html;

$this->title = 'test';
$this->params['breadcrumbs'][] = ['label' => 'Тест'];
?>

<?= Html::tag('h1', Html::encode($this->title), ['class' => 'h1']); ?>
