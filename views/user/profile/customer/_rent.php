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
	<li><?= $info->getDataLabels('c-data-rhcc'); ?></li>
	<li><?= $info->getDataLabels('c-data-rhsh'); ?></li>
	<li><?= $info->getDataLabels('c-data-rhpb'); ?></li>
	<li><?= $info->getDataLabels('c-data-rhp'); ?></li>
</ol>
<ol class="col col-b par-line par-line-b">
	<li><?= $data['c-data-rhcc'] ?></li>
	<li><?= $data['c-data-rhsh'] ?></li>
	<li><?= $data['c-data-rhpb'] ?> - <?= $data['c-data-rhpe'] ?></li>
	<li><?= $data['c-data-rhp'] ?></li>
</ol>
