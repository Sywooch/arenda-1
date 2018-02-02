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
        <style type="text/css">#hellopreloader>p{display:none;}#hellopreloader_preload{display: block;position: fixed;z-index: 99999;top: 0;left: 0;width: 100%;height: 100%;min-width: 1000px;background: rgba(241,243,244,.9) url('/images/svg/preloader.svg') center center no-repeat;background-size:210px;}#hellopreloader_preload_logo{position:absolute;top:50%;left:50%;background:url('/images/preloader-logo.png') no-repeat center center / 106px 81px;width:106px;height:81px;margin-left:-53px;margin-top:-50px;}#hellopreloader_preload_text{position:absolute;font-size:13px;color:#9f3053;font-weight:200;width:106px;left:50%;margin-left:-54px;height:30px;top:50%;margin-top:45px;text-align:center;}</style>
        <div id="hellopreloader"><div id="hellopreloader_preload"><div id="hellopreloader_preload_logo"></div><div id="hellopreloader_preload_text">Идет загрузка</div></div></div>
        <script type="text/javascript">var hellopreloader = document.getElementById("hellopreloader_preload");function fadeOutnojquery(el){el.style.opacity = 1;var interhellopreloader = setInterval(function(){el.style.opacity = el.style.opacity - 0.05;if (el.style.opacity <=0.05){ clearInterval(interhellopreloader);hellopreloader.style.display = "none";}},16);}window.onload = function(){setTimeout(function(){fadeOutnojquery(hellopreloader);},1000);};</script>
        <?php $this->beginBody() ?>
        <div class="page<?= Yii::$app->controller->pageBaseClass; ?>">
            <div class="page-inner page-inner--top">
                <?= $this->render('_header'); ?>
                <?= $this->render('_tags_pages', ['content' => $content]); ?>
                <?= $this->render('_footer'); ?>
            </div>
        </div>
        <script>
            $(function ()
            {
                console.log(window.location.hash)
            });
        </script>
        <?php $this->endBody() ?>
        <script>
            function showmodal() {
                jQuery('#passwordresetrequestform-email').val(jQuery('.shomodals').attr('data-email'));
                jQuery('#password-recovery').arcticmodal();
            }
        </script>
    </body>
</html>
<?php $this->endPage() ?>
