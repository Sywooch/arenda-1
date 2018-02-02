<?php

use app\components\extend\Html;
use yii\widgets\DetailView;
use app\models\UserPassport;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Данные пользователя: [' . $model->fullName . ']';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pass = UserPassport::find()->where(['user_id'=>$model->id])->one()

?>
<div class="user-view">
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Верификация', ['verify', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить пользователя?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'last_name',
            'email:email',
                [
                'attribute' => 'role',
                'value' => $model->getRoles($model->primaryKey, true),
            ],
                [
                'attribute' => 'status',
                'value' => $model->getStatusLabels($model->status)
            ],
            [
                'attribute' => 'passport.verify',
                'value' => $pass==null?UserPassport::getVerfiyLabels(UserPassport::VERIFY_UNVERIFIED):UserPassport::getVerfiyLabels($pass->verify)
            ],
                [
                'attribute' => 'created_at',
                'value' => $model->getDate('created_at','Y-m-d H:i')
            ],
                [
                'attribute' => 'updated_at',
                'value' => $model->getDate('updated_at','Y-m-d H:i')
            ],
        ],
    ])
    ?>

</div>
