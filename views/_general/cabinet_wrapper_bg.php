<?php
use app\components\widgets\SideHelper;

?>
<div class="wrapper-lk">
	<div class="lk-profile-t">
		<h1 class='lk-profile-t__title'><?php echo (isset($pageHeader)) ? $pageHeader : 'Страница' ?></h1>
		<?php
		if (isset($pageHeaderAddonView)) {
			echo $this->render($pageHeaderAddonView, (isset($pageHeaderAddonViewData)) ? $pageHeaderAddonViewData : []);
		}
		?>
	</div>

	<div class="col col-1">
		<?php if (isset($view)) {
			echo $this->render($view, (isset($data)) ? $data : []);
		} ?>
	</div>
	<div class="col col-2 col-i">
		<?= SideHelper::widget(); ?>
	</div>
</div>

