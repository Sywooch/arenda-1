<?php

use app\components\extend\Html;
use app\models\UserCustomerInfo;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $info app\models\UserCustomerInfo */
/* @var $data $info->data[...][$key][...] */
?>

<ol class="col col-a par-line par-line-g">
	<li><?= $info->getDataLabels('c-data-rfn'); ?></li>
	<li><?= $info->getDataLabels('c-data-rfl'); ?></li>
</ol>
<ol class="col col-b par-line par-line-b">
	<li class="h3"><?= $data['c-data-rfn'] ?></li>
	<li class="h3"><?= $data['c-data-rfl'] ?></li>
	<ol class="inf_item">
		<li>
			<a href="#!" class="link link--black">
				<i class="icon-mail"></i><span><?= $data['c-data-re'] ?></span>
			</a>
		</li>
		<li>
			<a href="#!" class="link link--black"><i class="icon-phone">
				</i><span><?= $data['c-data-rp'] ?></span>
			</a>
		</li>
		<!--<li><i class="icon-date"></i><span>04.10.1987 г.</span></li>-->
	</ol>
</ol>
