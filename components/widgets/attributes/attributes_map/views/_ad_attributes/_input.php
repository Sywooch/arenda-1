<?php

use app\models\AttributesMap;

/* @var $m \app\models\AttributesMap */
/* @var $this yii\web\View */
/* @var $model app\models\Ads */
/* @var $form yii\widgets\ActiveForm */


$options = [
    'onchange' => 'syncAttributesGroup($(this));',
    'data' => [
        'attribute-group-with' => $m->group_with,
        'attribute-parent' => $m->parent,
        'id' => $m->primaryKey,
    ]
];
if ($m->input_type == AttributesMap::INPUT_TYPE_RADIO || $m->input_type == AttributesMap::INPUT_TYPE_CHECKBOX) {
    $options['label'] = $m->label;
    $labelIsset = true;
}
?>

<?=
        $form->field($model, "details[" . ($m->primaryKey) . "]")
        ->{$m->input_type}($options)
        ->label((!isset($labelIsset) ? $m->label : ''))
        ->hint($m->hint);
?>