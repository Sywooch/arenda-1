<?php

use app\components\extend\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\UserPassport;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\models\User */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <hr>
    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-condensed'
        ],
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'first_name',
            'last_name',
            'email:email',
            [
                'attribute' => 'role',
                'value' => function($model) {
                    /* @var $model \app\models\User */
                    return $model->getRoles($model->primaryKey, true);
                },
                'filter' => $model->getRoleLabels(),
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    /* @var $model \app\models\User */
                    return $model->getStatusLabels($model->status);
                },
                'filter' => $model->getStatusLabels(),
            ],
            [
                'format' =>'raw',
                'attribute' => 'passport.verify',
                'value' => function($model) {
                    /* @var $pass UserPassport */
                    $pass = UserPassport::find()->where(['user_id'=>$model->id])->one();
                    return Html::a($pass==null?UserPassport::getVerfiyLabels(UserPassport::VERIFY_UNVERIFIED):UserPassport::getVerfiyLabels($pass->verify),['verify', 'id' => $model->id],['class'=>'btn btn-default']);
                },
                'filter' => UserPassport::getVerfiyLabels(),
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model) {
                    /* @var $model \app\models\User */
                    return $model->getDate('created_at','Y-m-d H:i');
                },
                'filter' => false,
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model) {
                    /* @var $model \app\models\User */
                    return $model->getDate('updated_at','Y-m-d H:i');
                },
                'filter' => false,
            ],
                ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
