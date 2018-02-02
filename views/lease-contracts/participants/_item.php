<?php

use app\components\extend\Html;

$user = $model->user;
?>
<div class="lk-temp__section lk-temp__section_residents">
	<!-- .lk-temp__item -->
	<div class="lk-temp__item lk-temp__item_residents">
		<!-- .lk-temp__top -->
		<div class="lk-temp__top_residents">
			<div class="lk-temp__info">
				<div class="lk-temp__name">
					<?= $user->fullName ?>
				</div>
				<a href="<?= $user->getProfileUrl() ?>" class="lk-temp__link_icon">Профиль</a>
				<table class="lk-temp__grid lk-temp__grid_info lk-temp__grid_residents">
					<tbody>
					<tr>
						<td>Контакты</td>
						<td>
							<?php if ($user->phone != ''): ?>
								<p>
									<?= $user->phone; ?>
								</p>
							<?php endif; ?>
							<p class="_gray">
								<?= Html::mailto($user->email, $user->email); ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>Доход</td>
						<td>
							<p>Не указан</p>
						</td>
					</tr>
					<tr>
						<td>Возраст</td>
						<td>
							<?php if ($user->date_of_birth != ''): ?>
								<p><?= $user->getAge(); ?> лет</p>
								<p class="_gray">
									<?= date('d', $user->date_of_birth); ?>
									<?= Yii::$app->controller->monthLabels(date('m', $user->date_of_birth), 2); ?>
									<?= date('Y', $user->date_of_birth); ?> года
								</p>
								<?php else: ?>
								<p>Не указан</p>
							<?php endif; ?>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="lk-temp__image-container">
				<div class="lk-temp__image">
					<?= Html::img($model->user->getAvatarUrl(['width' => 100, 'height' => 100])) ?>
				</div>
			</div>
		</div>
		<!-- .lk-temp__top  -->
		<!-- .lk-temp__footer -->
		<div class="lk-temp__footer lk-temp__footer_residents lk-temp__footer_with-button">
			<div class="lk-temp__result-wrapper lk-temp__result-wrapper_app">
				<!-- .lk-temp__result -->
				<div class="lk-temp__result lk-temp__result_app">
					<?php if ($check = $user->isCreditHistoryChecked()): ?>
						<h4 class="lk-temp-t__ok">Кредитная история </h4>
						<div class="lk-temp-app-item__inner">
							<a href="/scrining/credit?reportid=<?= $check->id?>&reqid=<?= $check->request_id?>">Результаты</a>
							<span class="_gray"><?= date('d.m.Y',$check->report_date)?></span>
						</div>
					<?php else: ?>
						<h4>Кредитная история </h4>
						<div class="lk-temp__inner lk-temp__inner_with-button">
							<a style="color: #000;" href="/scrining/request?type=<?=\app\models\ScreeningRequest::TYPE_CREDIT?>&userid=<?=$user->id?>" class="btn btn-normal btn-y">Запросить</a>
						</div>
					<?php endif; ?>
				</div>
				<!-- .lk-temp__result -->

				<!-- .lk-temp__result -->
				<div class="lk-temp__result lk-temp__result_app">
					<?php if ($check = $user->isDataChecked()): ?>
						<h4 class="lk-temp-t__ok">Проверка данных </h4>
						<div class="lk-temp-app-item__inner">
							<a href="/scrining/credit?reportid=<?= $check->id?>&reqid=<?= $check->request_id?>">Результаты</a>
							<span class="_gray"><?= date('d.m.Y',$check->report_date)?></span>
						</div>
					<?php else: ?>
						<h4>Проверка данных </h4>
						<div class="lk-temp__inner lk-temp__inner_with-button">
							<a style="color: #000;" href="/scrining/request?type=<?=\app\models\ScreeningRequest::TYPE_BIO?>&userid=<?=$user->id?>" class="btn btn-normal btn-y">Запросить</a>
						</div>
					<?php endif; ?>
				</div>
				<!-- .lk-temp__result -->
			</div>
		</div>
		<!-- .lk-temp__footer -->
	</div>
	<!-- .lk-temp__item -->
</div>