<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\extend\Controller;
use app\models\LeaseContracts;

?>
<?= Html::activeHiddenInput($model, 'date_created') ?>
<div class="wpapper-con wrapper-con-1">
	<div class="wpapper-con wrapper-con-2 bg-blue">
		<p class="h-m-18">Договор аренды жилого помещения</p>
		<h3 class="h-r-13">№ <?= $model->id ?></h3>
		<ol class="param-arg">
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Недвижимость</li>
				</ul>
				<ul class="param-dog-2">
					<li><?= $model->estate->getFullAddress() ?></li>
					<li><?= $model->estate->title ?></li>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Срок аренды</li>
				</ul>
				<ul class="param-dog-2">
					<li>
						с
						<?php
						$startDate = $model->date_begin;
						$contents = [];
						$contents[] = date('d', $startDate);
						$contents[] = Controller::monthLabels(date('m', $startDate), 2);
						$contents[] = date('Y', $startDate);
						echo implode(' ', $contents);
						?>
						по
						<?php
						$endDate = (strtotime('+' . $model->lease_term . 'month', $model->date_begin));
						$contents = [];
						$contents[] = date('d', $endDate);
						$contents[] = Controller::monthLabels(date('m', $endDate), 2);
						$contents[] = date('Y', $endDate);
						echo implode(' ', $contents);
						?>
					</li>
					<li><?= LeaseContracts::getLeaseTermLabels($model->lease_term) ?></li>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Участники</li>
				</ul>
				<ul class="param-dog-2">
					<?php foreach ($model->participants as $participant): ?>
					<li>
						<a href="<?= $participant->user->getProfileUrl() ?>">
							<?= $participant->user->first_name; ?>
						</a>
					</li>
					<li></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Стоимость аренды</li>
				</ul>
				<ul class="param-dog-2">
					<li><?= number_format($model->price_per_month, 0, '.', ' ') ?> <span class="rub">Р</span> в мес.</li>
					<li><?= number_format($model->price_per_month * 12, 0, '.', ' ') ?> <span class="rub">Р</span> в год</li>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Оплата</li>
				</ul>
				<ul class="param-dog-2">
					<li>По <?= $model->payment_date ?> числам месяца</li>
					<li><?php
						$startDate  = $model->date_begin;
						$contents   = [];
						$contents[] = date('d', $startDate);
						$contents[] = Controller::monthLabels(date('m', $startDate), 2);
						echo implode(' ', $contents);
						?> первая оплата</li>
				</ul>
			</li>
			<li class="param-arg-row">
				<ul class="param-dog-1">
					<li>Депозит</li>
				</ul>
				<ul class="param-dog-2">
					<li><?= $model->getDepositSum() ?></li>
				</ul>
			</li>
		</ol>
	</div>
</div>
<br>
<div style="text-align: center;">
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn--next', 'name' => 'button-action', 'value' => 'save']) ?>
</div>
<br>
<div class="separator-l"></div>
<div class="submit-form-row--2">
	<div class="submit-form-row--2__link">
		<a href="<?= Url::to(['create', 'id' => $model->id, 'step' => 4]) ?>" class="link link--prev-blue">
			Назад
		</a>
	</div>
</div>


