<?php

use app\components\extend\Html;
use app\models\AttributesMap;

/* @var $model \app\models\AttributesMap */
?>


<?= Html::tag(($model->parent > 0 ? 'h5' : 'h4'), (trim($model->label_for_customers) != '' ? $model->label_for_customers : $model->label)); ?>