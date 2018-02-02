<?php

use app\components\extend\Html;
use app\components\extend\Url;
use app\models\Ads;

$ad = $model->ad;
?>
<?php if (!$ad): ?>
	<div class="lk-realty__p-item lk-realty__p-item--mob-flex">
		<div class="lk-realty__p-name">
			Объявление
			<span class="status-round"></span>
		</div>
		<div class="lk-realty__p-content">
			<?php
			echo Html::a('Создать объявление', ['/ads/create', 'eId' => $model->primaryKey], [
				'class' => 'btn btn-normal btn-normal--vert-sm btn-bl',
				'data'  => [
					'pjax' => 0,
				],
			]);
			?>
		</div>
	</div>
<?php else: ?>
	<div class="lk-realty__p-item lk-realty__p-item--mob-block lk-realty__p-item--with-controls">
		<div class="lk-realty__p-name">
			Объявление
			<span class="status-round status-round<?= ($ad->status == Ads::STATUS_ACTIVE ? '--green' : '') ?>"></span>
		</div>
		<div class="lk-realty__p-content">
			<?php

			$ad_string = '';
			$ad_string .= number_format($ad->rent_cost_per_month, 0, '.', ' ');
			$ad_string .= ' <span class="rub">Р</span>' . ', ';
			$ad_string .= $ad->getNumberOfRooms() . ', ';
			$ad_string .= $ad->number_of_rooms_total_area . 'м<sup>2</sup> ';

			if ($ad->status != Ads::STATUS_DRAFT) {
				echo Html::a($ad_string, ['/ads/view', 'id' => $ad->primaryKey], [
					'class'  => 'lk-realty__p-subtitle',
					'title'  => 'Открыть объявление',
					'target' => '_blank',
					'data'   => [
						'pjax' => 0,
					],
				]);
			} else {
				echo Html::tag('span', $ad_string);
			}
			?>
			<p>
				Просмотров: всего <?= $ad->countAllViews() ?>, за сегодня <?= $ad->countTodayViews() ?>
			</p>
			<?php
			if ($ad->status != Ads::STATUS_DRAFT) {
				echo Html::a('Размещение на сайтах недвижимости', ['/ads/editboard', 'id' => $model->ad->id], [
					'class' => 'btn btn-normal btn-normal--vert-sm btn-bl',
					'data'  => [
						'pjax' => 0,
					],
				]);
			}
			?>
		</div>
		<div class="lk-realty__p-controls">
			<a data-pjax="0" href="<?= Url::to(['/ads/update', 'id' => $ad->primaryKey]) ?>" class="btn circle-btn">
				<span class="iconic iconic--pen"></span>
			</a>
			<?=
			Html::a('<span class="iconic iconic--can"></span>', '#!', [
				'class' => 'btn circle-btn js-modal-link-ajax',
				'title' => 'Удалить объявление',
				'data'  => [
					'href' => Url::to(['/ads/delete', 'id' => $ad->primaryKey]),
					'pjax' => 0,
				],
			]);
			?>
		</div>
	</div>

<?php endif; ?>