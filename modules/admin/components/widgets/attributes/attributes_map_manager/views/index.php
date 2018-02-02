<?php

use app\components\extend\Html;
use app\components\widgets\attributes\attributes_map\AttributesMapWidgetAssets;
use yii\web\View;
use app\models\AttributesMap;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\components\extend\Modal;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $model AttributesMap */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */
?>

<?php
Pjax::begin([
    'id' => 'attributesMapList'
]);


echo Html::tag('div', 'Добавить атрибут', [
    'onclick' => "openModalAttributesMapForm($(this),'#attributeMapManagerModal');",
    'class' => 'btn btn-success',
]);
?>
<hr/>

<!-- Modal -->
<div class="modal fade" id="attributeMapManagerModal" tabindex="-1" role="dialog" aria-labelledby="attributeMapManagerModal">
    <div class="modal-lg modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?= Html::tag('h3', 'Атрибут для объявлений'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php
                echo $this->render('_index/_form', [
                    'model' => $model
                ]);
                ?>
            </div>
        </div>
    </div>
</div>




<?=
ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_index/_item',
    'layout' => '{items}{pager}',
    'itemOptions' => [
        'class' => 'jumbotron'
    ]
])
?>
<?php Pjax::end(); ?>