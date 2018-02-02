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
	<li><?= $info->getDataLabels('c-data-ehj'); ?></li>
	<li><?= $info->getDataLabels('c-data-ehz'); ?></li>
	<li><?= $info->getDataLabels('c-data-ehpb'); ?></li>
	<li><?= $info->getDataLabels('c-data-ehpe'); ?></li>
	<?php if ($data['c-data-ehei'] != ''): ?>
		<li><?= $info->getDataLabels('c-data-ehei'); ?></li>
	<?php endif; ?>
</ol>
<ol class="col col-b par-line par-line-b">
	<li><?= $data['c-data-ehj'] ?></li>
	<li><?= isset($data['c-data-ehz']) ? $data['c-data-ehz'] : ' - '; ?></li>
	<li><?= $data['c-data-ehpb'] ?></li>
	<li><?= $data['c-data-ehpe'] ?></li>
	<?php if ($data['c-data-ehei'] != ''): ?>
		<li><?= $data['c-data-ehei'] ?></li>
	<?php endif; ?>
</ol>

