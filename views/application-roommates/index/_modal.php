<?php

use app\components\extend\Modal;
use app\components\extend\Html;

/* @var $model \app\models\ApplicationRoommates */
?>
<?php

Modal::begin([
    'id' => 'js-send-application-modal',
    'header' => Html::tag('h4', 'Пригласить сожителя'),
    'toggleButton' => [
        'onclick' => 'ApplicationRoommsmates.clearForm($(this))',
        'tag' => 'button',
        'class' => 'btn btn-info',
        'label' => 'Добавить',
    ]
]);
?>

<?=

$this->render('_modal/_form', [
    'model' => $model
]);
?>


<?php

Modal::end();
?>