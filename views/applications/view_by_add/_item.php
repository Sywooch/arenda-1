<?php

use app\models\Applications;
use app\components\extend\Html;
use app\components\extend\Url;
use app\components\extend\Controller;

/* @var $model \app\models\Applications */
?>

<div class="lk-temp-apps-item">
	<div class="lk-temp-apps-item__top">
		<div class="lk-temp-apps-item__section_f">
			<div class="lk-temp-apps-item__section">
				<a href="#" class="lk-temp__link">
					<div class="lk-temp-apps-item__status <?= ($model->is_new) ? '_active' : '_disable' ?>"></div>
					Заявка № <?= $model->primaryKey; ?>
				</a>
				<p class="lk-temp-apps__text">
					<?= date('d', $model->date_created) ?>
					<?= Controller::monthLabels(date('m', $model->date_created), 4); ?>
					<?= date('Y, H:i', $model->date_created) ?>
				</p>
			</div>
			<div class="lk-temp-apps-item__info">
				<div class="lk-temp-apps-item__info-item">
					<div class="lk-temp-apps-item__image">
						<?= Html::img($model->user->getAvatarUrl(['width' => 40, 'height' => 40])) ?>
					</div>
					<div>
						<div class="lk-temp-apps-item__name">
							<?= $model->user->fullName ?>
						</div>
						<?php
						$dataChecked = $model->user->isDataChecked();
						$creditHistoryChecked = $model->user->isCreditHistoryChecked();
						?>
						<?php if ($dataChecked || $creditHistoryChecked): ?>
							<?php if ($dataChecked): ?>
								<div class="lk-temp-apps__text">
									<div class="lk-temp-apps-item__status _ok"></div>
									Данные
								</div>
							<?php endif; ?>
							<?php if ($creditHistoryChecked): ?>
								<div class="lk-temp-apps__text">
									<div class="lk-temp-apps-item__status _ok"></div>
									Кредитная история
								</div>
							<?php endif; ?>
						<?php else: ?>
							<div class="lk-temp-apps__text lk-temp-apps__text_i">Проверки не проходил</div>
						<?php endif; ?>
					</div>
				</div>

			</div>
		</div>
		<div class="lk-temp-apps-item__section">
			<?php
			if ($isArchive) {
				if ($model->status != Applications::STATUS_DELETED) {
					echo Html::a('Удалить', '#!', [
						'class' => 'btn btn-normal btn-gr lk-temp__button_g js-modal-link-ajax',
						'title' => 'Удалить',
						'data'  => [
							'href' => Url::to(['delete', 'id' => $model->primaryKey]),
							'pjax' => 0,
						],
					]);
				}
			} else {
				if ($model->status != Applications::STATUS_IN_ARCHIVE) {
					echo Html::a('В архив', '#!', [
						'class' => 'btn btn-normal btn-gr lk-temp__button_g js-modal-link-ajax',
						'title' => 'В архив',
						'data'  => [
							'href' => Url::to(['archive', 'id' => $model->primaryKey]),
							'pjax' => 0,
						],
					]);
				}
			}
			?>
			<?=
			Html::a('Посмотреть', ['view', 'id' => $model->primaryKey], [
				'class' => 'btn btn-normal btw-w lk-temp__button_w',
				'title' => 'Посмотреть',
				'data'  => [
					'pjax' => 0,
				],
			]);
			?>
		</div>
	</div>
</div>
