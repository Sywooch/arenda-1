<?php

use app\components\extend\Html;
use app\models\AttributesMap;

/* @var $ad app\models\Ads */
/* @var $model \app\models\AttributesMap */
/* @var $value \app\models\AdAttributeValues */
?>

<?php $value = $model->getAdValues()->where(['ad_id' => $ad->primaryKey])->one(); ?>

<?php
switch ($model->input_type) {
    case AttributesMap::INPUT_TYPE_CHECKBOX :
        if ((int) $value->value > 0) {
            $val = $this->render('_label', ['model' => $model]);
        }
        break;
    case AttributesMap::INPUT_TYPE_RADIO:
        if ((int) $value->value > 0) {
            $val = $this->render('_label', ['model' => $model]);
        }
        break;
    case AttributesMap::INPUT_TYPE_HIDDEN:
        $val = $this->render('_label', ['model' => $model]);
        break;
    default :
        $val = $this->render('_label', ['model' => $model]) . $value->value;
        break;
}
if (isset($val) && trim($val != '')) {
    echo $val;
}
?>