<?php

use app\components\extend\Html;
use app\components\widgets\attributes\attributes_map\AttributesMapWidgetAssets;
use yii\web\View;
use app\models\AttributesMap;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
if ($map) {
    foreach ($map as $m) {
        /* @var $m \app\models\AttributesMap */
        ?>
        <?= $m->before; ?>
        <?=
        $this->render('_ad_attributes/_input', [
            'm' => $m,
            'form' => $form,
            'model' => $model
        ]);
        ?>

        <?=
        $this->render('_ad_attributes/childs', [
            'map' => $m->getChilds($m->primaryKey),
            'form' => $form,
            'model' => $model
        ])
        ?>

        <?= $m->after; ?>
        <?php
    }
}
?>