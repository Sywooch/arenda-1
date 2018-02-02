<?php

use app\components\extend\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = yii::$app->name;
?>

<?= Html::tag('h1', 'Оповещения'); ?>

<?=

ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'notifications/_item'
])
?>
