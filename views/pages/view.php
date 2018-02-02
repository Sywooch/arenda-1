<?php

use app\components\extend\Html;
use app\components\helpers\CommonHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
if(!Yii::$app->user->isGuest AND $model->url=='index')
{
    echo '<style>.bg-head .btn{visibility: hidden!important;}</style>';
}
?>

<?=
CommonHelper::str()->replaceTagsWithDatatValues($model->content, [
    'image_url' => $model->getFile('image')->url,
    'title' => $model->title,
    'signup_form' => Yii::$app->user->isGuest ? $this->render('//layouts/_blocks/registration-section', [
	    'model' => new app\models\forms\SignupForm()
    ]) : '',
    'contact_form' => $this->render('//layouts/_blocks/contact_form', [
        'model' => new app\models\forms\ContactForm()
    ])
]);
?>