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
        $tmp = '';
        /* @var $m \app\models\AttributesMap */
        ?>
        <?php
        $tmp.=$m->before;
        $tmp.=$this->render('_input', [
            'm' => $m,
            'form' => $form,
            'model' => $model
        ]);
        $tmp.=$m->after;
        $tmp.=$this->render('childs', [
            'map' => $m->getChilds($m->primaryKey),
            'form' => $form,
            'model' => $model
        ]);
        echo Html::tag('div', $tmp,[
            'style'=>'margin-left:25px;'
        ]);
    }
}
?>