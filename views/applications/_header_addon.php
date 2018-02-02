<?php
use app\components\extend\Url;
?>
<div class="lk-temp__buttonss lk-temp__buttons_checkbox" style="margin-bottom: 10px;">
	<div class="lk-temp__checkbox">
		<label for="c1">
			<input type="checkbox" name="c1" id="c1"
			       onclick="window.location = $(this).data('href')"
			       data-href="<?= Url::to(['/applications', 'activeAdsOnly' => !$activeAdsOnly]) ?>"
			       <?= ($activeAdsOnly) ? 'checked' : '' ?>
			>
			<i class="checkbox_item"></i>
			<span>Только с активными объявлениями</span>
		</label>
	</div>
</div>