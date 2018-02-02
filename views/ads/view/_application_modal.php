<?php

use app\components\extend\Modal;
use app\components\extend\Html;
use app\components\extend\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $model app\models\Ads */
?>
<?php

Modal::begin([
    'id' => 'js-send-application-modal',
    'header' => 'Отправить заявку',
    'toggleButton' => [
        'tag' => 'button',
        'class' => 'btn btn-sm btn-block btn-info',
        'label' => 'Отправить заявку!',
    ]
]);
?>


<?= Html::tag('h4', '1. Сожители') ?>
<?php

if ($roommates = $model->getMyApplication()->getRoommates()->all()) {
    echo implode(',', ArrayHelper::map($roommates, 'id', 'fullName'));
    echo '&nbsp;';
    echo Html::a('Редактировать', Url::to(['/application-roommates/index', 'ad' => $model->primaryKey]));
} else {
    echo Html::a('Добвить', Url::to(['/application-roommates/index', 'ad' => $model->primaryKey]));
}
?>

<?= Html::tag('h4', '2. Ваш профиль') ?>
<?= Html::a(yii::$app->user->identity->customerInfo ? 'Редактировать' : 'Заполнить', Url::to(['/user/profile-update', 'ad' => $model->primaryKey])) ?>

<?= Html::tag('h4', '3. Отчеты с проверок') ?>
<?= Html::a('Заполнить', Url::to([''])) ?>

<?= Html::tag('h4', '4. Подтверждение') ?>
<?=

Html::a('Подтвердить', Url::to(['applications/create', 'ad_id' => $model->primaryKey]), [
    'data' => [
        'confirm' => 'Отправить заявку ?',
    ]
])
?>

<?php

Modal::end();

if (yii::$app->request->get('c') == 1) {
    yii::$app->view->registerJs('$("#js-send-application-modal").modal("show");');
}
?>