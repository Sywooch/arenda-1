<?php
use app\components\widgets\SideHelper;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;


$str = CommonHelper::str();
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$page = $controller . '/' . $action;

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="wrapper-lk">
	<h1 class="lk-tit">Настройки</h1>

	<div class="col col-1 col-1">
		<ul class="lk_setting__nav">
			<li class="<?= $str->contain($page, 'settings/notifications', 'active'); ?>">
				<a href="<?= $str->contain($page, 'settings/notifications', '#', Url::to(['/settings/notifications'])); ?>">Уведомления</a>
			</li>
			<li class="<?= $str->contain($page, 'settings/password', 'active'); ?>">
				<a href="<?= $str->contain($page, 'settings/password', '#', Url::to(['/settings/password'])); ?>">Пароль</a>
			</li>
			<li class="<?= $str->contain($page, 'settings/account-delete', 'active'); ?>">
				<a href="<?= $str->contain($page, 'settings/account-delete', '#', Url::to(['/settings/account-delete'])); ?>">Удаление аккаунта</a>
			</li>
		</ul>
		<?php
		if (isset($view)) {
			echo $this->render($view, (isset($data)) ? $data : []);
		}
		?>
	</div>
	<div class="col col-2">
		<?= SideHelper::widget(); ?>
	</div>
</div>
