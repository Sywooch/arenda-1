<?php

use app\components\extend\Html;
use app\components\extend\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\components\widgets\SideHelper;
use app\models\PaymentMethods;

$this->title = 'Карты и счета';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="wrapper-lk">
	<div class="lk-profile-ts">
		<h1 class="lk-profile-t-t__title""><?= $this->title ?></h1>
		<p class="lk-profile-t__sub"></p>
	</div>

	<div class="col col-1 col-1 lk_carts_and_accounts">
		<div class="wrapper-con-2">
			<?= $this->render('index_inner', [
				'dataProviderCards'    => $dataProviderCards,
				'dataProviderAccounts' => $dataProviderAccounts,
				'inplatFormLinkUrl'    => $inplatFormLinkUrl,
			]); ?>
		</div>
	</div>
	<div class="col col-2">
		<?= SideHelper::widget(); ?>
	</div>
</div>
