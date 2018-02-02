<?php

use app\components\extend\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\components\widgets\attributes\attributes_map_manager\AttributesMapManagerWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AttributesMapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Атрибуты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attributes-map-index">
    <?=
    AttributesMapManagerWidget::widget([
        'params' => [
            'model' => $model,
        ]
    ])
    ?>
</div>
