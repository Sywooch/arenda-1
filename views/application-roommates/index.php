<?php

use app\components\extend\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ApplicationRoommatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сожители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-roommates-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    $this->render('index/_modal', [
        'model' => $model
    ]);
    ?>
    <?=
    Html::a('Продолжить заявку', Url::to(['/ads/view', 'id' => $ad, 'c' => 1]), [
        'class' => 'btn btn-success pull-right'
    ])
    ?>
    <hr/>
    <?php Pjax::begin(['id' => 'js-application-roommates-list-pjax']); ?>
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'index/_item',
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>
