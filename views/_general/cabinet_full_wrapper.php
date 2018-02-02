<?php
use app\components\widgets\SideHelper;
use yii\widgets\Pjax;

?>
<?php Pjax::begin([
	'id' => '__full-content-pjax-container',
]); ?>
<div class="wrapper-lk">
	<div class="<?= (isset($breadcrumbHeader)) ? 'lk-backTitle' : 'lk-profile-t' ?>">
		<?= (isset($breadcrumbHeader)) ? $breadcrumbHeader : '' ?>
		<h1 class="lk-profile-t__title"><?= (isset($pageHeader)) ? $pageHeader : '' ?></h1>
		<p class="lk-profile-t__sub"><?= (isset($pageSubHeader)) ? $pageSubHeader : '' ?></p>
		<?php
		if (isset($pageHeaderAddonView) && $pageHeaderAddonView) {
			echo $this->render($pageHeaderAddonView, (isset($pageHeaderAddonViewData)) ? $pageHeaderAddonViewData : []);
		}
		?>
	</div>
	<div class="lk-profile">
		<div class="col col-1<?= (isset($noBackground) && $noBackground == true) ? ' col-1_no-bg' : ''; ?>">
			<?php
			if (isset($view)) {
				echo $this->render($view, (isset($data)) ? $data : []);
			}
			?>
		</div>
		<div class="col col-2 col-i">
			<?= SideHelper::widget(); ?>
		</div>
	</div>
</div>
<?php Pjax::end(); ?>
