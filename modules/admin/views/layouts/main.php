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
    <body>
        <?php $this->beginBody() ?>
        <div id="container" class="effect mainnav-lg">
            <?php echo $this->render('_header'); ?>
            <div class="boxed">
                <?= $this->render('_main_menu'); ?>
                <div id="content-container">
                    <div id="page-title">
                        <h1 class="page-header text-overflow"><?= Html::encode($this->title) ?></h1>
                    </div>
                    <div id="page-content">
                        <?php echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
                        <div class="panel">
                            <div class="panel-body">
                                <?php echo Yii::$app->controller->flash ? Yii::$app->controller->flash : '' ?>
                                <?= $content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->render('_footer'); ?>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
