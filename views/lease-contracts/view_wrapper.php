<?php
use app\components\widgets\SideHelper;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;

$str = CommonHelper::str();
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$page = $controller . '/' . $action;

$this->title = $model->estate->title;
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="wrapper-lk">
	<div class="lk-backTitle">
		<a href="<?= Url::to(['/lease-contracts']) ?>" class="lk-temp__back">
			Договоры
		</a>
		<h1 class="lk-tit"><?= $model->estate->title; ?></h1>
		<p><?= $model->estate->getFullAddress(); ?></p>
	</div>
	<section class="lk-temp lk-temp-trans lk-temp cf">
		<div class="col col-1 col-1">
			<ul class="lk_setting__nav">
				<li class="<?= $str->contain($page, 'lease-contracts/contract', 'active'); ?>">
					<a <?= $str->contain($page, 'lease-contracts/contract', ' ', 'href="'.Url::to(['/lease-contracts/contract', 'id' => $model->id]).'"'); ?>>Договор</a>
				</li>
				<li class="<?= $str->contain($page, 'lease-contracts/transactions', 'active'); ?>">
					<a <?= $str->contain($page, 'lease-contracts/transactions', ' ', 'href="'.Url::to(['/lease-contracts/transactions', 'id' => $model->id]).'"'); ?>href="<?= Url::to(['/lease-contracts/transactions', 'id' => $model->id]); ?>">Транзакции</a>
				</li>
				<li class="<?= $str->contain($page, 'lease-contracts/participants', 'active'); ?>">
					<a <?= $str->contain($page, 'lease-contracts/participants', ' ', 'href="'.Url::to(['/lease-contracts/participants', 'id' => $model->id]).'"'); ?>>Жильцы</a>
				</li>
				<li class="<?= $str->contain($page, 'lease-contracts/history', 'active'); ?>">
					<a <?= $str->contain($page, 'lease-contracts/rent-history', ' ', 'href="'.Url::to(['/lease-contracts/rent-history', 'id' => $model->id]).'"'); ?>>История</a>
				</li>
				<li class="<?= $str->contain($page, 'lease-contracts/payjkx', 'active'); ?>">
					<a <?= $str->contain($page, 'lease-contracts/payjkx', ' ', 'href="'.Url::to(['/lease-contracts/payjkx', 'id' => $model->id]).'"'); ?>>Оплата ЖКУ</a>
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
	</section>
</div>
