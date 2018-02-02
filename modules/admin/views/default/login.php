<?php

use app\components\extend\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'authorization';
?>

<?php
echo Html::tag('h1', 'Вход');
$form = ActiveForm::begin([
            'id' => 'login-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => false
        ]);
?>

<?=
$form->field($model, 'email')->textInput([
    'placeholder' => $model->getAttributeLabel('email'),
    'class' => 'form-control'
])->label('');
?>
<?=
$form->field($model, 'password')->passwordInput([
    'placeholder' => $model->getAttributeLabel('password'),
    'class' => 'form-control'
])->label('');
?>
<hr/>
<div>
    <?=
    $form->field($model, 'rememberMe')->checkbox([
        'label' => $model->getAttributeLabel('rememberMe')
    ]);
    ?>
</div>


<div class="form-group">
    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    <?=
    Html::a('Сброс пароля', ['request-password-reset'], [
        'class' => 'btn btn-warning'
    ]);
    ?>
</div>


<?php ActiveForm::end(); ?>
   