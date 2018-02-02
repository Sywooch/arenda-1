<?php

use app\components\extend\Html;
use app\models\Notifications;

/* @var $model app\models\Notifications */
?>


<div class="alert alert-<?= $model->status == Notifications::STATUS_NEW ? 'success' : 'info' ?>">
    <?= $model->getDate('date_created'); ?>
    <?= $model->message; ?>
</div>

<?php
$model->markAsViewed();
