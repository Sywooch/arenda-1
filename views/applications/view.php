<?php

use app\components\extend\Html;
use yii\widgets\DetailView;
use app\models\Applications;
use app\components\extend\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Applications */

$this->title = $model->ad->estate->getName();
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => Url::to(['/applications/index'])];
$this->params['breadcrumbs'][] = ['label' => $model->ad->estate->getName(), 'url' => Url::to([
	'/applications/view-by-ad',
	'id' => $model->ad_id,
])];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS
$(document).ready(function() {
	$(document).on('click', '.js-modal-link-ajax', function(e) {
	    e.preventDefault();
	    
	    var href = $(this).data('href');
	    
		$.arcticmodal({
		    type: 'ajax',
		    url: href,		   
		});
	});
});
JS
);

?>
<!-- .lk-temp__top -->
<div class="lk-temp__top lk-temp__top--2">
	<div class="lk-temp__left"><h1 class="lk-temp__title">Заявка № <?= $model->id ?></h1></div>
	<div class="lk-temp__buttons">
		<?php
		if ($model->status == Applications::STATUS_IN_ARCHIVE) {
			echo Html::a('Удалить', '#!', [
				'class' => 'btn btn-normal btn-gr lk-temp__button_g js-modal-link-ajax',
				'title' => 'Удалить',
				'data'  => [
					'href' => Url::to(['delete', 'id' => $model->primaryKey, 'refresh' => false]),
					'pjax' => 0,
				],
			]);
		} else if ($model->status == Applications::STATUS_NEW) {
			echo Html::a('В архив', '#!', [
				'class' => 'btn btn-normal btn-gr lk-temp__button_g js-modal-link-ajax',
				'title' => 'В архив',
				'data'  => [
					'href' => Url::to(['archive', 'id' => $model->primaryKey, 'refresh' => false]),
					'pjax' => 0,
				],
			]);
		}
		?>

		<?php
		echo Html::a('Создать договор', ['/lease-contracts/create', 'appId' => $model->primaryKey], [
			'class' => 'btn btn-y btn-normal lk-temp__button_y',
			'title' => 'Удалить',
			'data'  => [
				'pjax' => 0,
			],
		]);
		?>
	</div>
</div>
<!-- .lk-temp__top -->

<!-- .lk-temp__body -->
<div class="lk-temp__body">
	<div class="lk-temp__items">
		<!-- .lk-temp__item -->
		<div class="lk-temp__item">
			<!-- .lk-temp__top -->
			<div class="lk-temp__top_application">
				<div class="lk-temp__info">
					<div class="lk-temp__name">
						<?= $model->user->fullName ?>
					</div>
					<table class="lk-temp__grid lk-temp__grid_info lk-temp__grid_app">
						<tbody>
						<tr>
							<td>Контакты</td>
							<td>
								<?php if ($model->user->phone != ''): ?>
									<p>
										<?= $model->user->phone; ?>
									</p>
								<?php endif; ?>
								<p class="_gray">
									<?= Html::mailto($model->user->email, $model->user->email); ?>
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
								<?php if ($model->user->date_of_birth != ''): ?>
									<p><?= $model->user->getAge(); ?> лет</p>
									<p class="_gray">
										<?= date('d', $model->user->date_of_birth); ?>
										<?= Yii::$app->controller->monthLabels(date('m', $model->user->date_of_birth), 2); ?>
										<?= date('Y', $model->user->date_of_birth); ?> года
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

					<a href="<?= $model->user->getProfileUrl() ?>" class="lk-temp__link_icon">Профиль</a>
				</div>
			</div>
			<!-- .lk-temp__top  -->
			<!-- .lk-temp__footer -->
			<div class="lk-temp__footer">
				<div class="lk-temp__result-wrapper lk-temp__result-wrapper_app">

					<!-- .lk-temp__result -->
					<div class="lk-temp__result lk-temp__result_app">
						<?php if ($model->user->isCreditHistoryChecked()): ?>
							<h4 class="lk-temp-t__ok">Кредитная история </h4>
							<div class="lk-temp-app-item__inner">
								<a href="#">Результаты</a>
								<span class="_gray">12.05.2016</span>
							</div>
						<?php else: ?>
							<h4>Кредитная история </h4>
							<div class="lk-temp__inner lk-temp__inner_with-button">
								<button class="btn btn-normal btn-y">Запросить</button>
							</div>
						<?php endif; ?>
					</div>
					<!-- .lk-temp__result -->

					<!-- .lk-temp__result -->
					<div class="lk-temp__result lk-temp__result_app">
						<?php if ($model->user->isDataChecked()): ?>
							<h4 class="lk-temp-t__ok">Проверка данных </h4>
							<div class="lk-temp-app-item__inner">
								<a href="#">Результаты</a>
								<span class="_gray">12.05.2016</span>
							</div>
						<?php else: ?>
							<h4>Проверка данных </h4>
							<div class="lk-temp__inner lk-temp__inner_with-button">
								<button class="btn btn-normal btn-y">Запросить</button>
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
	<!-- .b-informer -->
	<div class="b-informer">
		<h2 class="b-informer__title">Сравнение дохода</h2>
		<!-- .b-informer-item -->
		<div class="b-informer-item">
			<div class="b-informer-item__section">
				<span class="b-informer-item__in">0% </span>
				<span class="b-informer-item__text">составляет аренда от дохода</span>
			</div>
			<div class="b-informer-item__line">
				<svg height="4" style="background: #eaebeb;border-radius: 5px;">
					<line x1="0" y1="4.5" x2="0%" stroke="#ffc00f" stroke-width="9" stroke-linecap="round"
					      y2="4.5"></line>
				</svg>
			</div>
			<div class="b-informer-item__section">
				<span class="b-informer-item__text">Аренда: <?= $model->ad->getRentCostPerMonth() ?> </span>
			</div>
		</div>
		<!-- .b-informer-item -->
	</div>
	<!-- .b-informer -->
</div>
