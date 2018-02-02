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
	<li><?= $info->getDataLabels('c-data-ia'); ?></li>
	<li><?= $info->getDataLabels('c-data-ias'); ?></li>
</ol>
<ol class="col col-b par-line par-line-b">
	<li><?= $data['c-data-ia'] ?></li>
	<li><?= $data['c-data-ias'] ?></li>
</ol>