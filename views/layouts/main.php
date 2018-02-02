<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\components\extend\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\helpers\CommonHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body data-notification-top-margin="0">
        <?php $this->beginBody() ?>
        <div class="page<?= Yii::$app->controller->pageBaseClass; ?>">
            <div class="page-inner page-inner--top<?= (!Yii::$app->user->isGuest) ? '-lk' : ''; ?>">
                <?= $this->render('_header'); ?>
                <?= CommonHelper::data()->getParam('headerText') ?><span id="content-anchor"></span>
                <div class="page-body">
                    <?= $this->render('_tags', ['content' => $content]); ?>
                </div>
                <?= $this->render('_footer'); ?>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
