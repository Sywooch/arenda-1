<?php
use app\components\extend\Url;
?>
<?php if (!Yii::$app->user->isGuest) {
	$identity = Yii::$app->user->identity;
	if (!$identity->isCustomer) { ?>
		<div class="lk-temp__buttonss">
			<a href="<?= Url::to(['create']) ?>"
			   class="btn btn-y btn-normal lk-temp__button_agreements--y"
			   data-id-modal="createObject">
				Создать договор
			</a>
		</div>
	<?php }
}
?>