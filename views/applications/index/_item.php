<?php

use app\models\Applications;
use app\components\extend\Html;
use app\components\extend\Url;

/* @var $model \app\models\Applications */
?>

<div class="panel panel-info">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2 text-center">
                <?= Html::tag('div', $model->getDate('date_created')); ?>
            </div>

            <div class="col-md-2">
                <?=
                Html::tag('div', $model->user->renderAvatar([
                            'width' => 100
                ]));
                ?>
            </div>
            <div class="col-md-4 text-left">
                <?= $model->user->fullName ?>
            </div>
            <div class="col-md-3 text-right">
                <?=
                Html::a('Просмотреть', Url::to(['view', 'id' => $model->primaryKey]), [
                    'class' => 'btn btn-default '
                ])
                ?>
                <?=
                Html::a('В архив', ['archive', 'id' => $model->id], [
                    'class' => 'btn btn-danger ' . ($model->status != Applications::STATUS_IN_ARCHIVE ? '' : 'hidden'),
                    'data' => [
                        'confirm' => 'Отпрявить в ярхив ?',
                        'method' => 'post',
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
