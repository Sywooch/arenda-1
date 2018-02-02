<?php

use app\components\widgets\SideHelper;
use app\components\widgets\ProfileManageCenter\ProfileManageCenter;

$this->title = 'Центр управления';
$this->params['breadcrumbs'][] = ['label' => 'Центр управления'];
?>
<?= ProfileManageCenter::widget(); ?>