<?php

use app\components\helpers\CommonHelper;
use app\components\extend\Html;
use app\components\extend\Url;

$str = CommonHelper::str();
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$page = $controller . '/' . $action;
?>

<div class="header-lk__wr">
	<div class="header-lk  js-header-lk">
		<div class="wrapper-lk">
			<a href="<?= Url::to(['/user/index']) ?>" class="header-lk__logo"></a>
			<ul>
				<li class="info h4"><a href="<?= Url::to(['/how-it-works']) ?>">Как это работает?</a></li>
				<li class="info h4"><a href="<?= Url::to(['/prices']) ?>">Особенности сервиса</a></li>
			</ul>
			<a href="<?= Url::to(['/faq']) ?>" class="header-lk__btn">
				<i class="icon-help"></i>
				<span class="h4">Помощь</span>
			</a>
			<div class="header-lk__menu-btn">
				<div class="c-hamburger c-hamburger--htx  c-hamburger--lk js-burger-btn"><span></span></div>
			</div>
		</div>
		<div class="header-lk__mobilePoint header-lk__mobi-container js-burger-menu"
		     style="transform: translateY(0px);">

			<div class="b-mainlk-nav__item b-mainlk-nav__item--m ">
				<a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/lease-contracts/']) ?>">Договор найма</a>
			</div>
			<!--<div class="b-mainlk-nav__item b-mainlk-nav__item--m ">
				<a href="<?/*= Url::to(['/lease-contracts/']) */?>">Договор аренды</a>
			</div>-->
			<div class="b-mainlk-nav__item b-mainlk-nav__item--m ">
				<a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/applications']) ?>">Мои заявки</a>
			</div>
			<div class="b-mainlk-nav__item b-mainlk-nav__item--m ">
				<a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/scrining/orders']) ?>">Проверка данных</a>
			</div>
			<div class="b-mainlk-nav__item b-mainlk-nav__item--m <?= $str->contain($page, 'payment-methods', 'is-active') ?>">
				<a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/payment-methods']) ?>">Карты и счета</a>
			</div>
			<div class="b-mainlk-nav__item b-mainlk-nav__item--m  is-active">
				<?=
				Html::a('Личная страница', Url::to(['/user/profile'], [
					'onclick' => "window.location=$(this).attr('href')",
				]))
				?>
			</div>

			<div class="header-lk__btns-wr">
				<?= Html::a('Настройки', Url::to(['/settings/notifications']),[
					'class'=>'btn btn-y btn-normal btn-normal--s-ent js-modal-link',
                    'onclick' => "window.location=$(this).attr('href')",
				]); ?>
				<?=
				Html::a('Выйти', Url::to(['/site/logout']), [
					'class' => 'btn btn-y btn-normal btn-normal--w btn-normal--s-lw js-modal-link',
                    'onclick' => "window.location=$(this).attr('href')",
				])
				?>
			</div>
		</div>
	</div>

	<div class="page-nav header-lk__b-nav  js-header-lk-bottom">
		<div class="wrapper-lk">
			<div class="header-lk__logo-b">
				<a href="<?= Url::to(['/user/index']) ?>"><img src="/images/svg/logo-main.svg" alt=""></a>
			</div>
			<div class="header-lk__nav">

				<div class="b-mainlk-nav is-active  js-main-nav-lk">

					<div class="b-mainlk-nav__item <?= $str->contain($page, 'lease-contracts', 'is-active') ?>">
						<a href="<?= Url::to(['/lease-contracts/']) ?>">Договор найма
							<?php if (isset(Yii::$app->params['new_lc_part_counter']) && Yii::$app->params['new_lc_part_counter'] > 0): ?>
								<div class="b-mainlk-nav__counter"><?= Yii::$app->params['new_lc_part_counter']; ?></div>
							<?php endif; ?>
						</a>
						<div class="b-mainlk-nav__line"></div>
					</div>

					<div class="b-mainlk-nav__item <?= $str->contain($page, 'applications', 'is-active') ?>">
						<a href="<?= Url::to(['/applications']) ?>">Мои заявки</a>
						<div class="b-mainlk-nav__line"></div>
					</div>

					<div class="b-mainlk-nav__item <?= $str->contain($page, 'scrining/orders', 'is-active') ?>">
						<a href="<?= Url::to(['/scrining/orders']) ?>">Проверка данных
                            <?php if (isset(Yii::$app->params['new_scrining']) && Yii::$app->params['new_scrining'] > 0): ?>
                                <div class="b-mainlk-nav__counter"><?= Yii::$app->params['new_scrining']; ?></div>
                            <?php endif; ?>
                        </a>
						<div class="b-mainlk-nav__line"></div>
					</div>

					<div class="b-mainlk-nav__item <?= $str->contain($page, 'payment-methods', 'is-active') ?>">
						<a href="<?= Url::to(['/payment-methods']) ?>">Карты и счета</a>
						<div class="b-mainlk-nav__line"></div>
					</div>

					<div class="b-mainlk-nav__item  <?= $str->contain($page, 'user/profile', 'is-active') ?>">
						<a href="<?= Url::to(['/user/profile']) ?>">Профиль</a>
						<div class="b-mainlk-nav__line"></div>
					</div>
				</div>

				<div class="b-mainlk-nav-m  js-main-nav-select-lk">
					<div class="b-mainlk-nav-m__current">
                        <?php
                        if($str->contain($page, 'lease-contracts',true)){ echo 'Договор найма'; }
                        elseif($str->contain($page, 'applications',true)){ echo 'Мои заявки'; }
                        elseif($str->contain($page, 'scrining/orders',true)){ echo 'Проверка данных'; }
                        elseif($str->contain($page, 'payment-methods',true)){ echo 'Карты и счета'; }
                        elseif($str->contain($page, 'user/profile',true)){ echo 'Профиль'; }
                        else{ echo 'Договор найма'; }
                        ?>
                    </div>
					<div class="b-mainlk-nav-m__items is-active">
                        <div class="b-mainlk-nav-m__item">
                            <a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/lease-contracts/']) ?>">Договор найма
                                <?php if (isset(Yii::$app->params['new_lc_part_counter']) && Yii::$app->params['new_lc_part_counter'] > 0): ?>
                                    <div class="b-mainlk-nav__counter"><?= Yii::$app->params['new_lc_part_counter']; ?></div>
                                <?php endif; ?>
                            </a>
                            <div class="b-mainlk-nav__line"></div>
                        </div>

                        <div class="b-mainlk-nav-m__item">
                            <a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/applications']) ?>">Мои заявки</a>
                            <div class="b-mainlk-nav__line"></div>
                        </div>

                        <div class="b-mainlk-nav-m__item">
                            <a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/scrining/orders']) ?>">Проверка данных</a>
                            <div class="b-mainlk-nav__line"></div>
                        </div>

                        <div class="b-mainlk-nav-m__item">
                            <a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/payment-methods']) ?>">Карты и счета</a>
                            <div class="b-mainlk-nav__line"></div>
                        </div>

                        <div class="b-mainlk-nav-m__item">
                            <a onclick="window.location = $(this).attr('href')" href="<?= Url::to(['/user/profile']) ?>">Профиль</a>
                            <div class="b-mainlk-nav__line"></div>
                        </div>
					</div>
				</div>

			</div>
			<div class="header-lk__user-nav">
				<div class="b-userlk-nav js-click-is-active is-active">
					<div class="b-userlk-nav__current">
						<?= implode(' ', array_slice(explode(' ', Yii::$app->user->identity->fullName), 0, 2)); ?>
					</div>
					<div class="b-userlk-nav__sub-list js-click-toggle-active <?= $action = 'user/profile' ?> ">
						<div class="b-userlk-nav__title <?= $str->contain($page, 'settings/notifications', 'is-active') ?>">
							<?= Html::a('Настройки', Url::to(['/settings/notifications'])); ?>
						</div>
						<div class="b-userlk-nav__btn-wr">
							<?=
							Html::a('Выйти', Url::to(['/site/logout']), [
								'class' => 'btn btn-y btn-normal btn-normal--no-bg btn-normal--s-out',
							])
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$js =<<<JS
				$('.b-mainlk-nav-m__current').click(function(){
				    $(this).next('.is-active').toggle();
				});
JS;
$this->registerJS($js);
?>