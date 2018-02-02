<?php
/**
 * Created by PhpStorm.
 * User: Ulugbek
 * Date: 03.03.2017
 * Time: 9:22
 */
use yii\helpers\Url;
use app\models\UserPassport;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?><!-- .application -->
<div class="page-body page-body_pt">
	<div class="wrapper-lk">

		<!-- .application -->
		<section class="lk-temp lk-temp-apps cf">
			<!-- .application__top -->
			<div class="lk-temp__top lk-temp__top_apps" style="padding-top: 0px!important;">
                <div class="lk-profile-ts">
                    <h1 class="lk-profile-t-t__title"">Центр управления</h1>
                    <p class="lk-profile-t__sub"></p>
                </div>
				<?php if ($passport->verify == 0): ?>
					<div class="lk-temp__buttons lk-temp__buttons_checkbox _active">
						<a href="<?= Url::to(['/settings/personal-info#passport']) ?>"
						   class="btn btn-normal btn-w">
							Пройдите верификацию
						</a>
						<span>  и получите максимум возможностей от сервиса Арендатика</span>
					</div>
				<?php endif; ?>
			</div>
			<!-- .application__top -->

			<div class="dashboard">
				<div class="dashboard__item <?= $realestate == null ? '_gray' : '' ?>"><!-- _active-->
					<div class="dashboard__close"></div>
					<h2 class="dashboard__title">Недвижимость</h2>

					<?php if ($realestate != null): ?>
						<div class="dashboard__property dashboard-property">
							<?php foreach ($realestate as $esate):
								$ad = $esate->ad;
								?>
								<div class="dashboard-property__item">
									<div class="dashboard-property__img">
										<img src="<?= $esate->getCoverUrl(['width' => 48, 'height' => 48]); ?>" alt="">
									</div>
									<div class="dashboard-property__text">
										<span><a
												href="<?= $ad == null ? Url::to(['/ads/create', 'eId' => $esate->id]) : Url::to(['/ads/view', 'id' => $ad->id]) ?>"
												class="dashboard-info__link"><?= $esate->title; ?></a></span>
										<span class="dashboard-info__footer _gray"><?= $esate->smallAddress ?></span>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<a href="/real-estate" class="btn btn-normal btn-w dashboard__button">Просмотреть объекты</a>
					<?php else: ?>
						<div class="dashboard-empty">
							<div class="dashboard-empty__item">
								<div class="dashboard-empty__img">
									<img src="/images/dashboard-icon4.png" alt="">
								</div>
								<i>Вы еще не создали ни одного <br>
									объекта недвижимости</i>
							</div>
							<div class="dashboard-empty__item">
								<i>В случае если вы не создадите договор
									найма или, наоборот, вы получите
									договор найма на подписание, то это
									будет отображено в этом окне</i>
							</div>

						</div>
						<a href="/real-estate/add" class="btn btn-normal btn-w dashboard__button">Добавить объект</a>
					<?php endif; ?>

				</div>
				<div class="dashboard__item <?= $ads == null ? '_gray' : '' ?>">
					<div class="dashboard__close"></div>
					<h2 class="dashboard__title">Объявления</h2>

					<?php if ($ads != null): ?>
						<?php foreach ($ads as $ad): ?>
							<div class="dashboard__info dashboard-info">
								<span><a href="<?= $ad->url ?>"
								         class="dashboard-info__link"><?= $ad->title ?></a><sup><?= count($ad->getAdViewedCounter()) ?></sup></span>
								<span class="_gray"><?= $ad->estate->addressLine ?></span>
								<span><?= $ad->rentCostPerMonth ?></span>
								<?= $ad->checkBio() ?>
							</div>
						<?php endforeach; ?>
						<a href="/applications" class="btn btn-normal btn-w dashboard__button">Просмотреть все</a>
					<?php else: ?>
						<div class="dashboard-empty">
							<div class="dashboard-empty__item">
								<div class="dashboard-empty__img">
									<img src="/images/dashboard-icon5.png" alt="">
								</div>
								<i>Вы еще не размещали <br>
									ни одного объявления</i>
							</div>
							<div class="dashboard-empty__item">
								<i>Создайте и разместите объявление
									на различных сайтах недвижимости
									через Арендатику - информация о
									получаемых заявках будет
									отображаться здесь</i>
							</div>
						</div>
						<a href="/ads/create" class="btn btn-normal btn-w dashboard__button">Разместить объявление</a>
					<?php endif; ?>
				</div>
				<div class="dashboard__item _gray">
					<div class="dashboard__close"></div>
					<h2 class="dashboard__title">Оплата</h2>

					<div class="dashboard-empty__item">
						<div class="dashboard-empty__img">
							<img src="/images/dashboard-icon3.png" alt="">
						</div>
						<i>Вы еще не производили <br>
							финансовые операции</i>
					</div>
					<div class="dashboard-empty__item">
						<i>Для того, чтобы начать получать
							оплату за недвижимость добавьте
							объект и разместите объявление</i>
					</div>
					<a class="btn btn-normal btn-w dashboard__button">Создать запрос</a>
				</div>
				<div class="dashboard__item">
					<div class="dashboard__close"></div>
					<h2 class="dashboard__title">Профиль</h2>
					<div class="dashboard-residents__item">
						<?= $user->renderAvatar(['width' => 50, 'height' => 50, 'class' => 'dashboard-residents__img', 'style' => 'width:50px;height:50px;']); ?>
						<span class="dashboard-residents__name"><?= $user->fullNameAll ?></span>
					</div>
					<div class="dashboard-contacts">
						<?php if ($user->email != ''): ?>
							<div class="dashboard-contacts__item">
								<span class="icon-mail-sm"></span>
								<span><?= $user->email; ?></span>
							</div>
						<?php endif; ?>
						<?php if ($user->phone != ''): ?>
							<div class="dashboard-contacts__item">
								<span class="icon-phone-sm"></span>
								<span><?= $user->phone; ?></span>
							</div>
						<?php endif; ?>


						<?php if ($passport->place_of_residence != ''): ?>
							<div class="dashboard-contacts__item">
								<span class="icon-map-sm"></span>
								<span><?= $passport->place_of_residence; ?></span>
							</div>
						<?php endif; ?>
						<!--<div class="dashboard-contacts__item">
							<span class="icon-note-sm"></span>
							<span><a href="#">www.arenda.ru</a></span>
						</div>-->
						<?php if ($passport->verify == UserPassport::VERIFY_VERIFIED): ?>
							<div class="dashboard-contacts__item">
								<span class="icon-verif-sm"></span>
								<span class="_black">Верификация пройдена</span>
							</div>
						<?php endif; ?>
					</div>
					<div class="dashboard-contacts__bottom">
						<div class="dashboard-contacts__range dashboard-range">
							<div class="dashboard-range__line" style="width: <?= $fills['percent'] ?>%;"></div>
							<div class="dashboard-range__text">Профиль заполнен на <?= $fills['percent'] ?>%</div>
						</div>
						<?php if ($fills['passfillshow'] == true): ?>
							<a href="<?= Url::to(['/settings/personal-info#passport']) ?>"
							   class="btn btn-normal btn-w dashboard__button">Заполните паспортные данные</a>
						<?php endif; ?>
						<?php if ($info->photo == ''): ?>
							<?php
							$form = ActiveForm::begin([
								'options'                => ['enctype' => 'multipart/form-data', 'class' => 'img_download'],
								'enableAjaxValidation'   => false,
								'enableClientValidation' => false,
								//'action'=>'profile',
							]);
							?>
							<?= Html::activeFileInput($model, 'photo', ['id' => 'img_download', 'class' => 'img_download']) ?>
							<input name="only_file" type="text" value="yes">
							<label for="img_download" class="btn btn-normal btn-w dashboard__button">
								Загрузите фотографию
							</label>
							<?php ActiveForm::end(); ?>
						<?php endif; ?>
					</div>
					<a class="btn btn-normal btn-w dashboard__button" href="/user/profile-update">Перейти в профиль</a>
				</div>
			</div>

			<!-- .application__body -->
		</section>
		<!-- .application -->
	</div>

</div><!-- /page-body -->