<?php

use app\components\extend\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AttributesMap */

$this->title = 'Create Attributes Map';
$this->params['breadcrumbs'][] = ['label' => 'Attributes Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attributes-map-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
