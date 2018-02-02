<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\components\extend\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

AdminAsset::register($this);
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
    <body class="nifty-ready  pace-done">
        <div class="pace  pace-inactive">
            <div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
                <?php $this->beginBody() ?>
                <div class="pace-progress-inner"></div>
            </div>
            <div class="pace-activity"></div>
        </div>
        <div id="container" class="cls-container">
            <!-- BACKGROUND IMAGE -->
            <!--===================================================-->
            <div id="bg-overlay" style="background-image: url('/public/admin/img/bg-img/bg-img-6.jpg');" class="bg-img demo-my-bg"></div>
            <!-- HEADER -->
            <!--===================================================-->
            <div class="cls-header cls-header-lg">
                <div class="cls-brand">
                    <a class="box-inline" href="/admin">
                        <span class="brand-title"><?= yii::$app->name ?> </span>
                    </a>
                </div>
            </div>
            <!--===================================================-->

            <!-- LOGIN FORM -->
            <!--===================================================-->
            <div class="cls-content">
                <div class="cls-content-lg panel text-left">
                    <div class="panel-body">
                        <?php echo yii::$app->controller->flash ? yii::$app->controller->flash : '' ?>
                        <?= $content; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
