<?php

use app\components\extend\Html;
use app\models\UserCustomerInfo;
use app\components\extend\Url;
use app\models\User;
use app\components\widgets\SideHelper;

?>

<?= $this->render('_header', [
	'user'             => $user,
	'info'             => $info,
	'inviteLessorForm' => $inviteLessorForm,
	'inviteCustomerForm' => $inviteCustomerForm,
]); ?>

<div class="col col-1">
    <?= $this->render('_common', [
        'user'             => $user,
        'info'             => $info,
        'inviteLessorForm' => $inviteLessorForm,
		'inviteCustomerForm' => $inviteCustomerForm,
        'realEstate'       => $realEstate,
        'model'       => $model,
    ]); ?>

	<?php if (!$info): ?>
		<?php
		echo Html::tag('div', 'Данные профиля не заполнены, их можно заполнить перейдя по ссылки ниже', [
			'class' => 'text-warning',
		]);
		echo Html::a('Заполнить', Url::to(['/user/profile-update']));
		?>
	<?php else: ?>
		<div class="title-row title-row--empty">
			<div class="title-row__title">
				<p class="h2">Граждане, постоянно  проживающие совместно с Нанимателем</p>
			</div>
		</div>
		<div class="contant-row">
			<?php if (empty($info->addational)): ?>
				<p>Информация не предоставлена</p>
			<?php else: ?>
				<ol class="col col-a par-line par-line-g">
					<li>
						<?= $info->getDataLabels(UserCustomerInfo::DATA_ADDITIONAL_FIRST_NAME) . '/' . $info->getDataLabels(UserCustomerInfo::DATA_ADDITIONAL_LAST_NAME); ?>
					</li>
				</ol>
				<ol class="col col-b par-line par-line-b">
					<li>
						<?php $i = 1;
						foreach ($info->addational as $addational) {
							echo $addational['first_name'] . ' ' . $addational['last_name'] . '</br>';
						} ?>
					</li>
				</ol>
			<?php endif; ?>
		</div>		
	<?php endif; ?>
</div>
