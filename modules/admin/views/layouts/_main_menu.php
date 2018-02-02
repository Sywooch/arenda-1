<?php

use app\components\extend\Url;

$controller = Yii::$app->controller->id;
?>
<nav id="mainnav-container">
    <div id="mainnav">
        <div id="mainnav-shortcut">
            <ul class="list-unstyled">
                <li class="col-xs-4" data-content="Additional Sidebar" data-original-title="" title="">
                    <a id="demo-toggle-aside" class="shortcut-grid" href="#">
                        <i class="psi-sidebar-window"></i>
                    </a>
                </li>
                <li class="col-xs-4" data-content="Notification" data-original-title="" title="">
                    <a id="demo-alert" class="shortcut-grid" href="#">
                        <i class="psi-speech-bubble-comic-2"></i>
                    </a>
                </li>
                <li class="col-xs-4" data-content="Page Alerts" data-original-title="" title="">
                    <a id="demo-page-alert" class="shortcut-grid" href="#">
                        <i class="psi-warning-window"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content" tabindex="0">
                    <ul id="mainnav-menu" class="list-group">
                        <!--Category name-->
                        <li class="list-header">Навигация</li>
                        <!--Menu list item-->
                        <li  class="<?= $controller == 'default' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/default/index']) ?>">
                                <i class="psi-home"></i>
                                <span class="menu-title">
                                    <strong>Главная</strong>
                                </span>
                            </a>
                        </li>
                        <li  class="<?= $controller == 'pages' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/pages/index']) ?>">
                                <i class="glyphicon glyphicon-new-window"></i>
                                <span class="menu-title">
                                    <strong>Страницы</strong>
                                </span>
                            </a>
                        </li>
                        <li  class="<?= $controller == 'side-help' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/side-help/index']) ?>">
                                <i class="glyphicon glyphicon-comment"></i>
                                <span class="menu-title">
                                    <strong>Боковые подсказки</strong>
                                </span>
                            </a>
                        </li>
                        <?php /*
                        <li  class="<?= $controller == 'external-platforms' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/external-platforms/index']) ?>">
                                <i class="pli-gear"></i>
                                <span class="menu-title">
                                    <strong>Площадки</strong>
                                </span>
                            </a>
                        </li> */ ?>
                        <li  class="<?= $controller == 'adboards' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/adboards/index']) ?>">
                                <i class="pli-gear"></i>
                                <span class="menu-title">
                                    <strong>Площадки</strong>
                                </span>
                            </a>
                        </li>
                        <li  class="<?= $controller == 'agreement' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/agreement/index']) ?>">
                                <i class="pli-gear"></i>
                                <span class="menu-title">
                                    <strong>Договор аренды</strong>
                                </span>
                            </a>
                        </li>
                        <li  class="<?= $controller == 'user' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/user/index']) ?>">
                                <i class="pli-add-user-plus-star"></i>
                                <span class="menu-title">
                                    <strong>Пользователи</strong>
                                </span>
                            </a>
                        </li>
                        <li  class="<?= $controller == 'metro' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/metro/index']) ?>">
                                <i class="pli-wrench"></i>
                                <span class="menu-title">
                                    <strong>Станции метро</strong>
                                </span>
                            </a>
                        </li>
                        <li  class="<?= $controller == 'screening' ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/admin/screening/index']) ?>">
                                <i class="glyphicon glyphicon-user"></i>
                                <span class="menu-title">
                                    <strong>Скрининг отчеты</strong>
                                </span>
                            </a>
                        </li>
                       <!-- <li  class="<?/*= $controller == 'attributes-map' ? 'active' : '' */?>">
                            <a href="<?/*= Url::to(['/admin/attributes-map/index']) */?>">
                                <i class="psi-tactic"></i>
                                <span class="menu-title">
                                    <strong>Атрибуты</strong>
                                </span>
                            </a>
                        </li>-->
                    </ul>

                </div>
                <div class="nano-pane" style="display: none;"><div class="nano-slider" style="height: 20px;"></div></div></div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>