<?php

use app\components\extend\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RealEstate */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Недвижимость', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .page-body{
        background-color: #fff!important;
        padding: 30px 0;
    }
    .page-inner--top-lk {
        padding-top: 122px;
    }
    .page.page-lk .arg_i_add-1 {
        padding: 95px 0;
         border: 0px dashed #dadde2!important;
    }
    .page.page-lk .arg_i_add {
         position: absolute!important;
    }
</style>
<?= $this->render('_form_add', [
    'model' => $model,
    'estateUser' => $estateUser,
]) ?>
