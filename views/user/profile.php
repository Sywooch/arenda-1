<?php

use app\components\widgets\SideHelper;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = ['label' => 'Профиль'];
?>
<div class="wrapper-lk">


    <?= $this->render('profile/' . $view, [
        'user'             => $user,
        'info'             => $info,
        'inviteLessorForm' => $inviteLessorForm,
        'inviteCustomerForm' => $inviteCustomerForm,
        'realEstate'       => $realEstate,
        'model'       => $model,
    ]);
    ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="col col-2">
			<?= SideHelper::widget(); ?>
		</div>
    <?php endif; ?>
</div>
