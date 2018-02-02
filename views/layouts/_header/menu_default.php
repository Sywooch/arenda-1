<?php

use app\components\extend\Html;
use app\components\extend\Url;

$mainMenu = [
	'Собственникам жилья' => [
		'url'     => Url::to(['/ad']),
		'submenu' => 'lord',
	],
	'Нанимателям'         => [
		'url'     => Url::to(['/profile']),
		'submenu' => 'renter',
	],
	'Как это работает'    => [
		'url' => Url::to(['/how-it-works']),
	],
	'Условия и цены'      => [
		'url' => Url::to(['/prices']),
	],
	'Отзывы'              => [
		'url' => Url::to(['/reviews']),
	],
];

$mainMenuSubmenu = [
	'lord'   => [
		'Объявления'  => [
			'url' => Url::to(['/ad']),
		],
		'Заявки'      => [
			'url' => Url::to(['/renter-applications']),
		],
		'Проверка нанимателей'       => [
			'url' => Url::to(['/screening']),
		],
		'Проверка личных данных'     => [
			'url' => Url::to(['/data-checking']),
		],
		'Кредитная история' => [
			'url' => Url::to(['/credit-report']),
		],
		'Договор'              => [
			'url' => Url::to(['/contract']),
		],
		'Платежи'             => [
			'url' => Url::to(['/online-payment']),
		],
	],
	'renter' => [
		'Личный профиль нанимателя'        => [
			'url' => Url::to(['/profile']),
		],
		'Онлайн платежи'                   => [
			'url' => Url::to(['/online-payment-renter']),
		],
		'Пригласить собственника квартиры' => [
			'url' => Url::to(['/invite-lord']),
		],
	],
];
?>

<?php
$isSubmenuActive = false;
$mainMenuSubmenuItems = '';
foreach ($mainMenuSubmenu as $menu => $items) {
	$tmpItem = '';
	foreach ($items as $title => $params) {
		$linkOptions = (isset($params['options']) ? $params['options'] : []);
		$hasSubmenu = array_key_exists('submenu', $params);
		$url = $hasSubmenu ? 'javascript:void(0)' : $params['url'];
		$activeClass = ('/' . Yii::$app->request->pathInfo == $url ? 'active' : null);
		if ($activeClass) {
			$isSubmenuActive = 'header-level--' . $menu;
		}
		$data = [];
		$linkOptions['data'] = isset($linkOptions['data']) ? array_merge($linkOptions['data'], $data) : $data;
		$tmpItem .= Html::tag('li', Html::a($title, $url, $linkOptions), [
			'class' => $activeClass,
		]);
	}
	$mainMenuSubmenuItems .= Html::tag('ul', $tmpItem, [
		'class' => $menu,
	]);
}

$mainMenuItems = '';
foreach ($mainMenu as $title => $params) {
	$linkOptions = (isset($params['options']) ? $params['options'] : []);
	$hasSubmenu = array_key_exists('submenu', $params);
	$url = $params['url'];
	$activeClass = (('/' . Yii::$app->request->pathInfo == $url || $isSubmenuActive == 'header-level--' . ($hasSubmenu ? $params['submenu'] : '')) ? '_active' : null);
	$data = [];
	if ($hasSubmenu) {
		$data['submenu'] = $params['submenu'];
	}
	if ($activeClass && $hasSubmenu) {
		$isSubmenuActive = ' header-level--' . $params['submenu'];
	}
	$linkOptions['data'] = isset($linkOptions['data']) ? array_merge($linkOptions['data'], $data) : $data;
	$mainMenuItems .= Html::tag('li', Html::a($title, $url, $linkOptions), [
		'class' => 'header__b-menu-l' . ($activeClass ? ' _active' : ''),
	]);
}
$mainMenuItemsMob = '';
foreach ($mainMenu as $title => $params) {
	$linkOptions = (isset($params['options']) ? $params['options'] : []);
	$hasSubmenu = array_key_exists('submenu', $params);
	$url = $params['url'];
	$activeClass = (('/' . Yii::$app->request->pathInfo == $url || $isSubmenuActive == 'header-level--' . ($hasSubmenu ? $params['submenu'] : '')) ? '_active' : null);
	$data = [];
	if ($hasSubmenu) {
		$data['submenu'] = $params['submenu'];
	}
	if ($activeClass && $hasSubmenu) {
		$isSubmenuActive = ' header-level--' . $params['submenu'];
	}
	$linkOptions['data'] = isset($linkOptions['data']) ? array_merge($linkOptions['data'], $data) : $data;
	$mainMenuItemsMob .= Html::tag('div', Html::a($title, $url, $linkOptions), [
		'class' => 'b-mainlk-nav__item b-mainlk-nav__item--m' . ($activeClass ? ' is-active' : ''),
	]);
}
?>

	<header id="top" class="header js-header" style="z-index: 11;">
		<div class="header__top">
			<div class="wrapper-n">
				<div class="header__logo">
					<a href="/">
						<img src="/images/svg/logo.svg" alt="">
					</a>
				</div>
				<?php if (Yii::$app->user->isGuest): ?>
					<div class="header__user">
						<div class="header__login">
							<a href='#!' data-id-modal="registration"
							   class="btn btn-y btn-normal btn-normal--s-ent js-modal-link">Регистрация</a>
							<a href='#!' data-id-modal="login"
							   class="btn btn-y btn-normal btn-normal--no-bg btn-normal--s-lw js-modal-link">Вход</a>
						</div>
						<a href="#!" class="js-scroll-trigger">
							<div class="header__btn-burger">
								<div class="c-hamburger c-hamburger--htx  c-hamburger--lk js-burger-btn"><span></span>
								</div>
							</div>
						</a>
					</div>
				<?php else: ?>
					<div class="header__user">
						<div class="header__login">
							<a href="<?= Url::to(['/user/index']); ?>"
							   class="btn btn-y btn-normal btn-normal--s-ent js-modal-link">Личный кабинет</a>
						</div>
						<a href="#!" class="js-scroll-trigger">
							<div class="header__btn-burger">
								<div class="c-hamburger c-hamburger--htx  c-hamburger--lk js-burger-btn"><span></span>
								</div>
							</div>
						</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="header__mobilePoint header-lk__mobi-container js-burger-menu">
				<?= $mainMenuItemsMob; ?>
			<?php if (Yii::$app->user->isGuest): ?>
				<div class="header-lk__btns-wr">
					<a href="#!" class="btn btn-y btn-normal btn-normal--s-ent js-modal-link"
					   data-id-modal="registration">Регистрация</a>
					<a href="#!" class="btn btn-y btn-normal btn-normal--w btn-normal--s-lw js-modal-link"
					   data-id-modal="login">Вход</a>
				</div>
			<?php else: ?>
				<div class="header-lk__btns-wr">
					<?= Html::a('Личный кабинет', Url::to(['/user/index']),[
						'class'=>'btn btn-y btn-normal btn-normal--s-ent js-modal-link',
					]); ?>
					<?=
					Html::a('Выйти', Url::to(['/site/logout']), [
						'class' => 'btn btn-y btn-normal btn-normal--w btn-normal--s-lw js-modal-link',
					])
					?>
				</div>
			<?php endif; ?>
				<!--<div class="b-mainlk-nav__item b-mainlk-nav__item--m">
					<a href="">Платежи</a>
				</div>
				<div class="b-mainlk-nav__item b-mainlk-nav__item--m">
					<a href="">Мои заявки</a>
				</div>
				<div class="b-mainlk-nav__item b-mainlk-nav__item--m is-active">
					<a href="">Скрининг</a>
				</div>
				<div class="b-mainlk-nav__item b-mainlk-nav__item--m">
					<a href="">Профиль</a>
				</div>
				<div class="b-mainlk-nav__item b-mainlk-nav__item--m">
					<a href="">Управление счетом</a>
				</div>-->

			</div>
		</div>
		<div class="header__bottom">
			<div class="wrapper-n wrapper-ow">
				<div class="header__logo-icon js-submenu-icon">
					<a href="/"><img src="/images/svg/logo-main.svg" alt=""></a>
				</div>
				<ul class="header__b-menu js-submenu-m">
					<?= $mainMenuItems; ?>
				</ul>
			</div>
		</div>
	</header>

	<div style="display: none"
	     class="<?= $isSubmenuActive ? 'active' : '' ?> header-level js-header-level is-fixed <?= $isSubmenuActive ?>">
		<div class="wrapper">
			<?= $mainMenuSubmenuItems; ?>
		</div>
	</div>
<?php
if ($isSubmenuActive) {
	//Yii::$app->view->registerCss('.page-body{padding-top: 25px;}');
}
?>