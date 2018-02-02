<?php

use app\components\extend\Html;
use app\components\extend\Url;

/* @var $model \app\models\AttributesMap */
?>
<br/>
<div class="row thumbnail">
    <div class=" col-md-8">
        <?=
        Html::tag('div', ((int) $model->group_with > 0 ? $model->getGroup()->label . ' - ' : '') . $model->label, [
            'class' => 'text-info'
        ]);
        ?>
        <?=
        Html::tag('div', Html::tag('b', $model->getAttributeLabel('label_for_customers')) . ' : ' .
                ($model->label_for_customers ? $model->label_for_customers : 'Нет'), ['class' => 'text-muted']);
        ?>
        <?=
        Html::tag('div', Html::tag('b', $model->getAttributeLabel('hint')) . ' : ' .
                ($model->hint ? $model->hint : 'Нет'), ['class' => 'text-muted']);
        ?>
        <?=
        Html::tag('div', Html::tag('b', $model->getAttributeLabel('input_type')) . ' : ' .
                $model->getInputTypesLabels($model->input_type), ['class' => 'text-muted']);
        ?>
        <?=
        Html::tag('div', Html::tag('b', $model->getAttributeLabel('show_to_customers')) . ' : ' .
                ($model->show_to_customers == 1 ? 'да' : 'нет'), ['class' => 'text-muted']);
        ?>
    </div>
    <div class="col-md-4 text-right">
        <?=
        Html::tag('div', '', [
            'class' => 'btn btn-danger glyphicon glyphicon-trash',
            'onclick' => 'deleteAttributeMapItem($(this));',
            'data' => [
                'url' => Url::to(['/admin/attributes-map/delete', 'id' => $model->primaryKey])
            ]
        ]);
        ?>
        <?=
        Html::tag('div', '', [
            'class' => 'btn btn-success glyphicon glyphicon-pencil',
            'onclick' => 'updateAttributeMapItem($(this));',
            'data' => [
                'model' => $model->attributes,
            ]
        ]);
        ?>
    </div>
</div>

<?php
if ($childs = $model->getChilds()) {
    $tmp = '<br/>';
    foreach ($childs as $c) {
        $tmp.= $this->render('_item', [
                    'model' => $c,
        ]);
    }
    echo Html::tag('div', $tmp.'<br/>',[
        'style'=>'margin-left: 30px'
    ]);
}
?>
