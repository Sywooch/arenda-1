<?php

use app\components\extend\Html;
use yii\helpers\Json;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ApplicationRoommates */
?>



<div class="panel panel-info ">
    <div class="panel-heading">
        <?=
        Html::tag('h5', 'Сожитель &numero;' . ($index + 1), [
            'class' => 'pull-left'
        ])
        ?>
        <div class="pull-right">
            <?=
            Html::tag('i', '', [
                'class' => 'glyphicon glyphicon-pencil btn btn-default',
                'onclick' => 'ApplicationRoommsmates.edit($(this))',
                'data' => [
                    'm' => Json::encode($model->attributes)
                ]
            ])
            ?>
            <?=
            Html::tag('i', '', [
                'class' => 'glyphicon glyphicon-trash btn btn-danger',
                'onclick' => 'ApplicationRoommsmates.remove($(this))',
                'data' => [
                    'm' => Json::encode($model->attributes),
                    'url' => Url::to(['delete', 'id' => $model->primaryKey])
                ]
            ])
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?= $model->fullName; ?>
    </div>
</div>