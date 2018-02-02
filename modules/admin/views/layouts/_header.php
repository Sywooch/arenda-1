<?php

use app\components\extend\Url;
use app\components\extend\Html;

$user = yii::$app->user->identity;
?>

<header id="navbar">
    <div id="navbar-container" class="boxed">

        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="/admin" class="navbar-brand">
                <img src="/public/admin/img/logo.png" alt="Nifty Logo" class="brand-icon">
                <div class="brand-title">
                    <span class="brand-text">
                        <?= yii::$app->name ?>
                    </span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->


        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="pli-view-list"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->



                <!--Notification dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="dropdown">
                    <a href="<?= Url::to(['/admin/default/notifications']); ?>">
                        <i class="pli-bell"></i>
                        <?php
                        $cNotifications = $user ? $user->countNewNotifications() : null;
                        if ($cNotifications > 0) {
                            ?>
                            <span class="badge badge-header badge-danger"><?= $cNotifications ?></span>
                            <?php
                        }
                        ?>
                    </a>
<!--
                    Notification dropdown menu
                    <div class="dropdown-menu dropdown-menu-md">
                        <div class="pad-all bord-btm">
                            <p class="text-lg text-semibold mar-no">Info.</p>
                        </div>
                    </div>-->
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End notifications dropdown-->



                <!--Mega dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="mega-dropdown">
                    <a href="#" class="mega-dropdown-toggle">
                        <i class="pli-layout-grid"></i>
                    </a>
                    <div class="dropdown-menu mega-dropdown-menu">
                        <div class="clearfix"> 
                            <div class="col-md-12">
                                some data
                            </div>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End mega dropdown-->

            </ul>
            <ul class="nav navbar-top-links pull-right">
                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="pull-right">
                            <img class="img-circle img-user media-object" src="/public/admin/img/av1.png" alt="Profile Picture">
                        </span>
                        <div class="username hidden-xs">
                            <?= yii::$app->user->identity->fullName; ?>
                        </div>
                    </a>


                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">
                        <!-- Dropdown footer -->
                        <div class="pad-all text-right">
                            <?php
                            echo Html::beginForm(['/admin/default/logout'], 'post', ['class' => 'navbar-form'])
                            . Html::submitButton(
                                    'Выход', ['class' => 'btn btn-primary']
                            )
                            . Html::endForm()
                            ?>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->

            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>