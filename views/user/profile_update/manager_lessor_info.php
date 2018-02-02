<?php

use yii\bootstrap\ActiveForm;
use app\components\extend\Html;

?>

<?=
$this->render('common_info', [
	'model' => $model,
	'user'  => $user,
	'form'  => $form,
    'readonly' => $readonly,
]);
?>


