<?php
/**
 * Created by PhpStorm.
 * User: Ulugbek
 * Date: 03.03.2017
 * Time: 9:22
 */
use app\components\extend\Controller;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\UserPassport;
use yii\widgets\ActiveForm;

?><!-- .application -->
<div class="page-body page-body_pt">
    <div class="wrapper-lk">

        <!-- .application -->
        <section class="lk-temp lk-temp-apps cf">
            <!-- .application__top -->
            <div class="lk-temp__top lk-temp__top_apps" style="padding-top: 0px!important;">
                <div class="lk-profile-t-t__title"">
                    <h1 class="lk-temp__title">Центр управления</h1>
                    <p class="lk-profile-t__sub"></p>
                </div>
                <?php if($passport->verify==0):?>
                    <div class="lk-temp__buttons lk-temp__buttons_checkbox _active">
                        <a style="text-transform: uppercase; font-weight: 500;" href="<?= Url::to(['/settings/personal-info#passport'])?>" class="btn-y btn btn-normal btn-w">
                            Пройдите верификацию
                        </a>
                        <span>  и получите максимум возможностей от сервиса Арендатика</span>
                    </div>
                <?php endif; ?>
            </div>
            <!-- .application__top -->

            <div class="dashboard">
                <div class="dashboard__item <?=$contract==null?'_gray':''?>">
                    <div class="dashboard__close"></div>
                    <h2 class="dashboard__title">Договор найма</h2>
                    <?php if($contract!=null):?>
                        <div class="dashboard__info dashboard-info">
                            <span><a href="<?= Url::to(['/lease-contracts/contract','id'=>$contract->id])?>" class="dashboard-info__link"><?= $contract->estate->title ?></a></span>
                            <span class="_gray"><?= $contract->estate->smallAddress ?></span>
                            <span><?=$contract->pricePerMonth ?></span>
                            <span class="dashboard-info__footer _gray">
                                с
                                <?php
                                $startDate  = $contract->date_begin;
                                $contents   = [];
                                $contents[] = date('d', $startDate);
                                $contents[] = Controller::monthLabels(date('m', $startDate), 2);
                                $contents[] = date('Y', $startDate);
                                echo implode(' ', $contents);
                                ?>
                                по
                                <?php
                                $endDate    = (strtotime('+' . $contract->lease_term . 'month', $contract->date_begin));
                                $contents   = [];
                                $contents[] = date('d', $endDate);
                                $contents[] = Controller::monthLabels(date('m', $endDate), 2);
                                $contents[] = date('Y', $endDate);
                                echo implode(' ', $contents);
                                ?></span>
                        </div>
                        <div class="dashboard__residents dashboard-residents">
                            <div class="dashboard-residents__title">Жильцы</div>
                            <?php $i = 1;
                            foreach ($contract->participants as $participant) :
                                if($i>3){ break; }
                                ?>
                                <div class="dashboard-residents__item">
                                    <?= Html::img($participant->user->getAvatarUrl(['width' => 49, 'height' => 49]),['class'=>'dashboard-residents__img']) ?>
                                    <a href="<?= $user->getProfileUrl() ?>" class="dashboard-residents__name"><?=$participant->user->fullNameAll ?></a>
                                </div>
                            <?php
                            $i++;
                            endforeach;
                            ?>
                        </div>
                        <a href="<?= Url::to(['/lease-contracts/contract','id'=>$contract->id])?>" class="btn btn-normal btn-w dashboard__button">Просмотреть договор</a>

                    <?php else: ?>
                        <div class="dashboard-empty">
                            <div class="dashboard-empty__item">
                                <div class="dashboard-empty__img">
                                    <img src="/images/dashboard-icon1.png" alt="">
                                </div>
                                <i>Вы еще не подписали ни одного <br>
                                    договора найма</i>
                            </div>
                            <div class="dashboard-empty__item">
                                <i>В случае если вы не создадите договор
                                    найма или, наоборот, вы получите
                                    договор найма на подписание, то это
                                    будет отображено в этом окне</i>
                            </div>
                        </div>
                        <a class="btn btn-normal btn-w dashboard__button">Добавить объект</a>
                    <?php endif; ?>
                </div>
                <div class="dashboard__item <?=$apps==null?'_gray':''?>">
                    <div class="dashboard__close"></div>
                    <h2 class="dashboard__title">Мои заявки</h2>
                    <?php if($apps!=null): ?>
                        <?php foreach ($apps as $aded):
                            $ad = $aded->ad;
                            ?>
                            <div class="dashboard__info dashboard-info">
                                <span><a href="<?=$ad->url ?>" class="dashboard-info__link"><?=$ad->title ?></a><sup><?=count($ad->getAdViewedCounter()) ?></sup></span>
                                <span class="_gray"><?=$ad->estate->addressLine ?></span>
                                <span><?=$ad->rentCostPerMonth ?></span>
                                <?=$ad->checkBio() ?>
                            </div>
                        <?php endforeach; ?>
                        <a href="/applications" class="btn btn-normal btn-w dashboard__button">Просмотреть все</a>
                    <?php else: ?>
                        <div class="dashboard-empty">
                            <div class="dashboard-empty__item">
                                <div class="dashboard-empty__img">
                                    <img src="/images/dashboard-icon2.png" alt="">
                                </div>
                                <i>К вам еще не подали ни одной <br>
                                    заявки на наем квартиры</i>
                            </div>
                            <div class="dashboard-empty__item">
                                <i>Выберите квартиру из нашей базы
                                    для подачи заявки</i>
                            </div>
                        </div>
                        <a href="/applications" class="btn btn-normal btn-w dashboard__button">Разместить объявление</a>
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
                        <?= $user->renderAvatar(['width' => 50, 'height' => 50,'class'=>'dashboard-residents__img','style'=>'width:50px;height:50px;']); ?>
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
                            <div class="dashboard-range__line" style="width: <?=$fills['percent']?>%;"></div>
                            <div class="dashboard-range__text">Профиль заполнен на <?=$fills['percent']?>%</div>
                        </div>
                        <?php if ($fills['passfillshow']): ?>
                            <a href="<?= Url::to(['/settings/personal-info#passport'])?>" class="btn btn-normal btn-w dashboard__button">Заполните паспортные данные</a>
                        <?php endif; ?>
                        <?php if ($info->photo == ''): ?>
                            <?php
                            $form = ActiveForm::begin([
                                'options'                => ['enctype' => 'multipart/form-data','class'=>'img_download'],
                                'enableAjaxValidation'   => false,
                                'enableClientValidation' => false,
                                //'action'=>'profile',
                            ]);
                            ?>
                            <?= Html::activeFileInput($model, 'photo',['id'=>'img_download','class'=>'img_download']) ?>
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