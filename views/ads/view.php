<?php

use app\components\extend\Html;
use app\models\Ads;
use app\models\RealEstate;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */
/* @var $realEstate RealEstate */
/* @var $realEstate app\models\behaviors\common\SaveFilesBehavior */
/* @var $user \app\models\User */

$this->registerJsFile('@web/public/app/js/site/scripts/ad_lightbox.js');
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyAzAb9tHd0V7GCo6xuPKQPYcO5Zt6yMBIg');
$this->registerJsFile('http://api-maps.yandex.ru/2.1/?lang=ru-RU');

$this->registerJs(<<<JS
    ymaps.ready(init);
    function init(){	  
        var coord = $('.__full-address').text();
        
        ymaps.geocode(coord).then(function (res) { // кодируем полученный из coords адрес в коордитаны 
        address = res.geoObjects.get(0).geometry.getCoordinates();
       
        ymaps.geocode(address, {
         kind: 'metro',
         results: 1
        }).then(function (met) {
                met.geoObjects.options.set('preset', 'islands#redCircleIcon');
              
                var metro = met.geoObjects;
                      var res = '';
                      met.geoObjects.each(function (obj) {
                        res += obj.properties.get('name');
                      });
                      
                      if (res != '') {
                          $('.__metro-station-name').text(res);
                          $('.__metro-station').show();
                      }
                  });
        
        });
    }
JS
);

$this->title                   = $realEstate->getName() . ' - ' . $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="publication">
    <div class="publication__inner wrapper-n">
        <?php
        if ($model->cover->isNewRecord) {
            echo Html::tag('div', '', [
                'class' => 'publication__head',
            ]);
        } else {
            $headerImageUrl = $model->cover->file->getImageUrl(['width' => 1226, 'height' => 400]);
            echo Html::tag('div', Html::tag('div', '', ['class'=>$model->estate->check_status == RealEstate::CHECK_STATUS_SUCCESS ? 'ad_check__success' : 'ad_check__fail']), [
                'class' => 'publication__head publication__head_image',
                'style' => "background: url('{$headerImageUrl}');",
            ]);
        }
        ?>
        <div class="publication__main ">
            <div class="wrapper-f">
                <div class="wrapper-f_column wrapper-f_column_info ">
                    <div class="publication-info publication-info--no">
                        <div class="publication-info__top">
                            <p>Стоимость</p>
                            <?php if ($model->rent_cost_per_month > 0): ?>
                                <table class="publication-info__table">
                                    <tbody>
                                    <tr>
                                        <td class="publication-info__td">
                                            <b class="publication-info__cost">
                                                <?= $model->getRentCostPerMonth() ?>
                                            </b>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                        <style>span.rub:after{top: auto; display: none;}</style>
                        <?php if($model->getRentTerm() != '' || $model->getRentAvailable() != '' || $model->getRentPledge() != ''): ?>
                        <div class="publication-info__body">
                            <table class="publication-info__table">
                                <tbody>
                                <?php if ($model->getRentTerm() != ''): ?>
                                    <tr>
                                        <td class="publication-info__td">Минимальная аренда</td>
                                        <td class="publication-info__td"><?= $model->getRentTerm() ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($model->getRentAvailable() != ''): ?>
                                    <tr>
                                        <td class="publication-info__td">Доступно</td>
                                        <td class="publication-info__td"><?= $model->getRentAvailable(); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($model->getRentPledge() != ''): ?>
                                    <tr>
                                        <td class="publication-info__td">Залог</td>
                                        <td class="publication-info__td"><?= $model->getRentPledge(); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                        <?php if ($model->check_credit_reports || $model->check_biographical_information): ?>
                            <div class="publication-info__footer">
                                <?php if ($model->check_credit_reports): ?>
                                    <div class="publication-info__item">
                                        <i class="icon-publication-check">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 16 16">
                                                <defs>
                                                    <style>
                                                        #ads-check.cls-1 {
                                                            fill: #9e2e54;
                                                            fill-rule: evenodd;
                                                        }
                                                    </style>
                                                </defs>
                                                <path id="ads-check" class="cls-1"
                                                      d="M1243.66,731.656a8,8,0,1,0-11.32,0A8.007,8.007,0,0,0,1243.66,731.656Zm-8.53-6.879,1.8,1.8,3.94-3.938,1.4,1.394-3.94,3.938-1.4,1.394-1.39-1.394-1.8-1.8Z"
                                                      transform="translate(-1230 -718)"></path>
                                            </svg>
                                        </i>
                                        <span>Проверка кредитной истории</span>
                                        <i class="icon-publication-question tooltip"
                                           data-tooltip="Всплывающее сообщение">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                 viewBox="0 0 18 18">
                                                <defs>
                                                    <style>
                                                        #ads-q.cls-1 {
                                                            fill: #767f80;
                                                            fill-rule: evenodd;
                                                        }
                                                    </style>
                                                </defs>
                                                <path id="ads-q" class="cls-1"
                                                      d="M1484,747a9,9,0,1,0,9,9A8.975,8.975,0,0,0,1484,747Zm0.82,13.909a0.39,0.39,0,0,1-.41.409h-0.82a0.39,0.39,0,0,1-.41-0.409v-0.818a0.39,0.39,0,0,1,.41-0.409h0.82a0.39,0.39,0,0,1,.41.409v0.818Zm1.1-3.641a3,3,0,0,0-1.1,1.268,0.4,0.4,0,0,1-.41.327h-0.82a0.4,0.4,0,0,1-.41-0.45A3.857,3.857,0,0,1,1484.9,756a2.074,2.074,0,0,0,1.15-1.637,2.05,2.05,0,0,0-4.1,0v0.246a0.37,0.37,0,0,1-.28.45l-0.78.245a0.409,0.409,0,0,1-.53-0.327,3.164,3.164,0,0,1-.04-0.614,3.68,3.68,0,1,1,7.36,0A3.586,3.586,0,0,1,1485.92,757.268Z"
                                                      transform="translate(-1475 -747)"></path>
                                            </svg>
                                        </i>
                                    </div>
                                <?php endif; ?>
                                <?php if ($model->check_biographical_information): ?>
                                    <div class="publication-info__item">
                                        <i class="icon-publication-check">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 16 16">
                                                <defs>
                                                    <style>
                                                        #ads-check.cls-1 {
                                                            fill: #9e2e54;
                                                            fill-rule: evenodd;
                                                        }
                                                    </style>
                                                </defs>
                                                <path id="ads-check" class="cls-1"
                                                      d="M1243.66,731.656a8,8,0,1,0-11.32,0A8.007,8.007,0,0,0,1243.66,731.656Zm-8.53-6.879,1.8,1.8,3.94-3.938,1.4,1.394-3.94,3.938-1.4,1.394-1.39-1.394-1.8-1.8Z"
                                                      transform="translate(-1230 -718)"></path>
                                            </svg>
                                        </i>
                                        <span>Проверка биографических даннных</span>
                                        <i class="icon-publication-question tooltip"
                                           data-tooltip="Всплывающее сообщение">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                 viewBox="0 0 18 18">
                                                <defs>
                                                    <style>
                                                        #ads-q.cls-1 {
                                                            fill: #767f80;
                                                            fill-rule: evenodd;
                                                        }
                                                    </style>
                                                </defs>
                                                <path id="ads-q" class="cls-1"
                                                      d="M1484,747a9,9,0,1,0,9,9A8.975,8.975,0,0,0,1484,747Zm0.82,13.909a0.39,0.39,0,0,1-.41.409h-0.82a0.39,0.39,0,0,1-.41-0.409v-0.818a0.39,0.39,0,0,1,.41-0.409h0.82a0.39,0.39,0,0,1,.41.409v0.818Zm1.1-3.641a3,3,0,0,0-1.1,1.268,0.4,0.4,0,0,1-.41.327h-0.82a0.4,0.4,0,0,1-.41-0.45A3.857,3.857,0,0,1,1484.9,756a2.074,2.074,0,0,0,1.15-1.637,2.05,2.05,0,0,0-4.1,0v0.246a0.37,0.37,0,0,1-.28.45l-0.78.245a0.409,0.409,0,0,1-.53-0.327,3.164,3.164,0,0,1-.04-0.614,3.68,3.68,0,1,1,7.36,0A3.586,3.586,0,0,1,1485.92,757.268Z"
                                                      transform="translate(-1475 -747)"></path>
                                            </svg>
                                        </i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($realEstate->user_id != Yii::$app->user->id): ?>
                    <button type="button" data-id-modal="sendRequest"
                            class="btn btn-y btn-full publication-info__button js-modal-link">
                        Отправить заявку
                    </button>
                    <?php endif; ?>
                    <div class="publication-info__share">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <defs>
                                <style>
                                    #ads-share.cls-1 {
                                        fill: #767f80;
                                        fill-rule: evenodd;
                                    }
                                </style>
                            </defs>
                            <path id="ads-share" class="cls-1"
                                  d="M1267.96,890.279a3.114,3.114,0,0,0-2.4,1.116l-4.66-2.455a2.7,2.7,0,0,0,.17-0.943,2.516,2.516,0,0,0-.18-0.947l4.66-2.452a3.1,3.1,0,0,0,2.41,1.123,2.866,2.866,0,1,0-3.04-2.861,2.505,2.505,0,0,0,.18.947l-4.66,2.452a3.088,3.088,0,0,0-2.41-1.123,2.866,2.866,0,1,0,.01,5.721,3.105,3.105,0,0,0,2.41-1.126l4.66,2.455a2.551,2.551,0,0,0-.18.953A3.04,3.04,0,1,0,1267.96,890.279Zm0-9.379a1.967,1.967,0,1,1-2.08,1.964A2.025,2.025,0,0,1,1267.96,880.9Zm-9.92,9.06a1.967,1.967,0,1,1,2.08-1.963A2.033,2.033,0,0,1,1258.04,889.96Zm9.92,5.14a1.967,1.967,0,1,1,2.08-1.964A2.025,2.025,0,0,1,1267.96,895.1Z"
                                  transform="translate(-1255 -880)"></path>
                        </svg>
                        <a href="#!" class="publication-info__link js-modal-link" data-id-modal="sharePublish">Поделиться
                            объявлением</a>
                    </div>
                </div>
                <div class="wrapper-f_column">

                    <!-- .publication-profile -->
                    <div class="publication-profile">
                        <div class="publication-profile__avatar">
                            <?= Html::img($user->getAvatarUrl(['width' => 100, 'height' => 100])) ?>
                        </div>
                        <div class="publication-profile__info">
                            <div class="publication-profile__role"><?= $user->getRoles($user->primaryKey, true) ?></div>
                            <div class="publication-profile__name"><?= $user->fullName ?></div>
                        </div>
                    </div>
                    <!-- .publication-profile -->

                    <!-- .publication-feature -->
                    <div class="publication-feature">
                        <h1 class="publication-feature__title _title"><?= $model->title ?></h1>
                        <p class="publication-feature__subtitle __metro-station">
                            <i class="icon-metro">
                                <svg id="mm.svg" xmlns="http://www.w3.org/2000/svg" width="26" height="21"
                                     viewBox="0 0 26 21">
                                    <defs>
                                        <style>
                                            #m.cls-1 {
                                                fill: #e03333;
                                                fill-rule: evenodd;
                                            }

                                            .cls-2 {
                                                fill: #28c269;
                                                stroke: #fff;
                                                stroke-linejoin: round;
                                                stroke-width: 2px;
                                            }
                                        </style>
                                    </defs>
                                    <path id="m" class="cls-1"
                                          d="M393.526,644.068H393.35l-3.753,7.1-3.888-7.164-5.323,12.943h-1.375v1.04h7.536v-1.04h-1.5l1.5-4.045,3.05,5.085,2.931-5.085,1.5,4.045h-1.5v1.04H400v-1.04h-1.3Z"
                                          transform="translate(-379 -644)"></path>
                                    <circle class="cls-2" cx="18.563" cy="13.063" r="4"></circle>
                                </svg>
                            </i>
                            <span class="__metro-station-name">-</span>
                        </p>
                        <p class="publication-feature__address">
                            <span class="__full-address"><?= $realEstate->getFullAddress(); ?></span>
                            <a href="#map" class="js-goToAddress publication-feature__link">показать на карте</a>
                        </p>
                        <ul class="publication-feature__list">
                            <li class="publication-feature__item">
                                <div class="publication-feature__top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="46" height="45" viewBox="0 0 46 45">
                                        <defs>
                                            <style>
                                                #ads-icon1.cls-1 {
                                                    fill: #3c454e;
                                                    fill-rule: evenodd;
                                                }
                                            </style>
                                        </defs>
                                        <path id="ads-icon1" class="cls-1"
                                              d="M438.922,735H395.078A1.074,1.074,0,0,0,394,736.071v34.286a1.074,1.074,0,0,0,1.078,1.071h24.8a1.071,1.071,0,1,0,0-2.142H411.25v-2.857a1.078,1.078,0,0,0-2.156,0v2.857H396.156V752.143h12.938v5.714a1.078,1.078,0,0,0,2.156,0v-1.429h13.656a1.071,1.071,0,1,0,0-2.142H411.25V741.429a1.078,1.078,0,0,0-2.156,0V750H396.156V737.143h41.688v17.143h-5.75v-2.858a1.079,1.079,0,0,0-2.157,0v3.929a1.075,1.075,0,0,0,1.079,1.071h6.828v21.429H428.5v-7.143a1.078,1.078,0,0,0-2.156,0v8.214A1.075,1.075,0,0,0,427.422,780h11.5A1.075,1.075,0,0,0,440,778.928V736.071A1.074,1.074,0,0,0,438.922,735Z"
                                              transform="translate(-394 -735)"></path>
                                    </svg>
                                </div>
                                <div class="publication-feature__text"><?= $model->getHouseTypeLabels($model->house_type); ?></div>
                            </li>
                            <li class="publication-feature__item">
                                <div class="publication-feature__top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="44" viewBox="0 0 60 44">
                                        <defs>
                                            <style>
                                                #ads-icon2.cls-1 {
                                                    fill: #3c454e;
                                                    fill-rule: evenodd;
                                                }
                                            </style>
                                        </defs>
                                        <path id="ads-icon2" class="cls-1"
                                              d="M611.9,756.056V740.793A3.739,3.739,0,0,0,608.228,737H561.772a3.74,3.74,0,0,0-3.676,3.793v15.263a3.735,3.735,0,0,0-3.1,3.721v9.447a1.176,1.176,0,0,0,1.157,1.195h1.24v5.892a1.177,1.177,0,0,0,1.158,1.195h2.089v2.3a1.158,1.158,0,1,0,2.315,0v-2.3h44.082v2.3a1.158,1.158,0,1,0,2.315,0v-2.3h2.089a1.177,1.177,0,0,0,1.158-1.195v-5.892h1.24A1.176,1.176,0,0,0,615,769.224v-9.447A3.734,3.734,0,0,0,611.9,756.056Zm-51.492-15.263a1.384,1.384,0,0,1,1.36-1.4h46.457a1.385,1.385,0,0,1,1.361,1.4v15.22h-4.064c0.808-.9,1.631-1.843,2.483-2.854a1.223,1.223,0,0,0,0-1.568,95.968,95.968,0,0,0-10-10.32,1.131,1.131,0,0,0-1.52,0,96.073,96.073,0,0,0-10,10.32,1.226,1.226,0,0,0,0,1.568c0.852,1.011,1.675,1.956,2.483,2.854h-7.947c0.808-.9,1.631-1.843,2.483-2.854a1.223,1.223,0,0,0,0-1.568,96.07,96.07,0,0,0-10-10.32,1.131,1.131,0,0,0-1.52,0,96.07,96.07,0,0,0-10,10.32,1.223,1.223,0,0,0,0,1.568c0.852,1.011,1.675,1.955,2.483,2.854h-4.063v-15.22Zm31.756,15.22c-1.065-1.128-2.141-2.327-3.264-3.638a91.9,91.9,0,0,1,8.346-8.614,91.9,91.9,0,0,1,8.346,8.614c-1.123,1.311-2.2,2.51-3.263,3.638H592.167Zm-24.5,0c-1.065-1.129-2.141-2.327-3.264-3.638a91.9,91.9,0,0,1,8.346-8.614,92.033,92.033,0,0,1,8.347,8.614c-1.123,1.311-2.2,2.509-3.264,3.638H567.668Zm42.62,19.1H559.712v-4.7h50.576v4.7Zm2.4-7.087h-55.37v-8.253a1.356,1.356,0,0,1,1.332-1.375h52.7a1.356,1.356,0,0,1,1.333,1.375v8.253h0Z"
                                              transform="translate(-555 -737)"></path>
                                    </svg>
                                </div>
                                <div class="publication-feature__text"><?= $model->getNumberOfRooms() ?>
                                    (<?= $model->getNumberOfBedrooms() ?>)
                                </div>
                            </li>
                            <?php if (($model->getNumberOfCombinedBathrooms() != '') || ($model->getNumberOfSeparateBathrooms() != '')): ?>
                                <li class="publication-feature__item">
                                    <div class="publication-feature__top">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="59.812"
                                             viewBox="0 0 60 59.812">
                                            <defs>
                                                <style>
                                                    #ads-icon3.cls-1 {
                                                        fill: #3c454e;
                                                        fill-rule: evenodd;
                                                    }
                                                </style>
                                            </defs>
                                            <path id="ads-icon2" class="cls-1"
                                                  d="M773,778.008H763v-2.239a7.278,7.278,0,0,0,5.241-5.072l3.552-12.748a2.983,2.983,0,0,0-.793-5.863V722.592a2.415,2.415,0,0,0-4.121-1.7l-2.59,2.582a5.77,5.77,0,0,0-7.558.485,0.994,0.994,0,0,0,0,1.41l7.071,7.05a1,1,0,0,0,1.414,0,5.725,5.725,0,0,0,.486-7.535l2.59-2.582a0.4,0.4,0,0,1,.452-0.09,0.393,0.393,0,0,1,.256.382v29.494H738v-1.994H725v1.994h-8a2.983,2.983,0,0,0-.793,5.863l3.552,12.748A7.278,7.278,0,0,0,725,775.769v2.239H715A1,1,0,1,0,715,780h58A1,1,0,1,0,773,778.008Zm-8.586-47.8-5.467-5.45a3.781,3.781,0,0,1,4.524.609l0.331,0.33A3.757,3.757,0,0,1,764.414,730.207ZM771,754.08a1,1,0,1,1,0,1.994H738V754.08h33Zm-35-1.994v10.967h-9V752.086h9Zm-9,12.961h9v1.994h-9v-1.994ZM717,754.08h8v1.994h-8A1,1,0,1,1,717,754.08Zm4.686,16.084-3.37-12.1H725v10.967h13V758.068h31.685l-3.37,12.1a5.3,5.3,0,0,1-5.089,3.856H726.774A5.294,5.294,0,0,1,721.686,770.164Zm34.7,5.85,1,1.994H730.618l1-1.994h24.764ZM727,778.008v-1.994h2.382l-1,1.994H727Zm32.618,0-1-1.994H761v1.994h-1.382ZM761,734.14a1,1,0,0,0,1-1v-1a1,1,0,0,0-2,0v1A1,1,0,0,0,761,734.14Zm-1,6.979a1,1,0,0,0,2,0v-1a1,1,0,0,0-2,0v1Zm0,3.988a1,1,0,0,0,2,0v-1a1,1,0,0,0-2,0v1Zm0,3.988a1,1,0,0,0,2,0v-1a1,1,0,0,0-2,0v1Zm0-11.964a1,1,0,0,0,2,0v-1a1,1,0,0,0-2,0v1Zm-8.536-4.452a1,1,0,0,0,.707-0.292l0.707-.7a1,1,0,0,0-1.414-1.41l-0.707.7A1,1,0,0,0,751.464,732.679Zm-2.828,2.821a1,1,0,0,0,.707-0.292l0.707-.7a1,1,0,1,0-1.414-1.41l-0.707.705A1,1,0,0,0,748.636,735.5Zm-2.828,2.819a1,1,0,0,0,.707-0.292l0.707-.705a1,1,0,0,0-1.414-1.409l-0.707.705A1,1,0,0,0,745.808,738.319Zm8.485-8.459a1,1,0,0,0,.707-0.292l0.707-.7a1,1,0,1,0-1.414-1.41l-0.707.705A1,1,0,0,0,754.293,729.86Zm-14.142,14.1a1,1,0,0,0,.707-0.292l0.707-.7a1,1,0,0,0-1.414-1.41l-0.707.705A1,1,0,0,0,740.151,743.959Zm-5.657,5.641a1,1,0,0,0,.707-0.293l0.707-.705a1,1,0,0,0-1.414-1.409l-0.707.705A1,1,0,0,0,734.494,749.6Zm8.485-8.461a1,1,0,0,0,.707-0.292l0.708-.7a1,1,0,1,0-1.415-1.41l-0.708.705A1,1,0,0,0,742.979,741.139Zm-5.657,5.64a1,1,0,0,0,.707-0.292l0.707-.7a1,1,0,1,0-1.414-1.41l-0.707.705A1,1,0,0,0,737.322,746.779Zm15.822-6.915a0.987,0.987,0,0,0,.484.125,1,1,0,0,0,.875-0.513l0.485-.871a1,1,0,0,0-1.748-.968l-0.485.872A1,1,0,0,0,753.144,739.864Zm2.04-5.714-0.486.871a1,1,0,0,0,1.748.969l0.486-.871A1,1,0,0,0,755.184,734.15Zm1.844-1.258a1,1,0,0,0,1.36-.387l0.486-.872a1,1,0,0,0-1.748-.969l-0.486.872A1,1,0,0,0,757.028,732.892Zm-6.41,13.556,0.485-.871a1,1,0,0,0-1.748-.967l-0.485.871A1,1,0,0,0,750.618,746.448Zm1.943-3.485,0.486-.871a1,1,0,0,0-1.748-.969l-0.486.871A1,1,0,0,0,752.561,742.963Zm-3.788,4.745a1,1,0,0,0-1.36.388l-0.287.516a1,1,0,0,0,1.748.967l0.287-.516A0.994,0.994,0,0,0,748.773,747.708Z"
                                                  transform="translate(-714 -720.188)"></path>
                                        </svg>
                                    </div>
                                    <div
                                            class="publication-feature__text"><?= $model->getNumberOfCombinedBathrooms() ?> <?= $model->getNumberOfSeparateBathrooms() ?></div>
                                </li>
                            <?php endif; ?>
                            <li class="publication-feature__item">
                                <div
                                        class="publication-feature__top publication-feature__top_size"> <?= $model->getTotalArea(); ?>
                                    <span class="_fz36">m<sup>2</sup></span></div>
                                <div class="publication-feature__text">Общая площадь</div>
                            </li>
                        </ul>
                    </div>
                    <!-- .publication-feature -->
                    
                    <?php if (isset($model->accommodation_type)): ?>
                        <div class="publication-desc">
                            <h2 class="publication-desc__title _title">Тип жилья</h2>
                            <?= $model->getAccommodationTypeLabels($model->accommodation_type) ?>
                        </div>
                    <?php endif ?>


                    <!-- .publication-desc -->
                    <div class="publication-desc">
                        <h2 class="publication-desc__title _title">Общая информация</h2>
                        <ul class="publication-desc__list">
                            <li class="publication-desc__li">
                                Этажность дома: <?= $model->house_floors ?>
                            </li>
                            <li class="publication-desc__li">
                                Этаж расположения: <?= $model->location_floor ?>
                            </li>
                            <li class="publication-desc__li">
                                Тип дома: <?= $model->getBuildingTypeLabels($model->building_type); ?>
                            </li>
                            <li class="publication-desc__li">
                                Состояние: <?= $model->getConditionTypeLabels($model->condition); ?>
                            </li>
                        </ul>

                        <?php if($model->description): ?>
                            <p>Описание: <?= $model->description; ?></p>
                        <?php endif; ?>

                        <?php if (in_array($model->pets_condition,
                            [Ads::PETS_CONDITION_ALLOWED, Ads::PETS_CONDITION_NOT_ALLOWED])): ?>
                            <h2 class="publication-desc__title _title">Домашние животные</h2>
                            <ul class="publication-desc__list">
                                <li class="publication-desc__li">
                                    <?php if ($model->pets_condition == Ads::PETS_CONDITION_ALLOWED): ?>
                                        <?php if (count($model->pets_allowed_list)): ?>
                                            Разрешены:

                                            <?php
                                            $allowedPets = [];

                                            foreach ($model->pets_allowed_list as $petId) {
                                                $allowedPets[] = $model->getPetsAllowedLabels($petId);
                                            }

                                            echo implode(', ', $allowedPets);
                                            ?>
                                        <?php else: ?>
                                            Разрешены
                                        <?php endif; ?>

                                    <?php elseif ($model->pets_condition == Ads::PETS_CONDITION_NOT_ALLOWED): ?>
                                        Запрещены
                                    <?php endif; ?>
                                </li>
                            </ul>
                        <?php endif; ?>

                        <?php if ( ! empty($model->facilities)): ?>
                            <h2 class="publication-desc__title _title">Удобства</h2>
                            <?php
                            $facilities      = $model->facilities;
                            $facilitiesCount = count($facilities);
                            if ($facilitiesCount < 1) {
                                $facilitiesCount = 1;
                            }
                            $facilitiesTypesChunkSize = ceil($facilitiesCount / 4);
                            if ($facilitiesTypesChunkSize == 1) {
                                $facilitiesChunks = [$facilities];
                            } else {
                                $facilitiesChunks = array_chunk($facilities, $facilitiesTypesChunkSize, true);
                            }
                            
                            $fContent = [];
                            foreach ($facilitiesChunks as $facilitiesChunk) {
                                $fContent[] = Html::beginTag('ul', ['class' => 'publication-desc__list']);
                                foreach ($facilitiesChunk as $facility) {
                                    $fContent[] = Html::tag('li', Ads::getFacilitiesAllLabels($facility),
                                        ['class' => 'publication-desc__li']);
                                }
                                $fContent[] = Html::endTag('ul');
                            }
                            
                            echo implode("\n", $fContent);
                            ?>
                        <?php endif; ?>
                        
                        <?php if($model->facilities_other): ?>
                            <p>Другие удобства: <?= $model->facilities_other ?></p>
                        <?php endif; ?>


                        <h2 class="publication-desc__title _title" onclick="$(this).next().toggle();">Проверка объекта</h2>
                        <div style="display: none;">
                            <?php if ($model->estate->check_status == RealEstate::CHECK_STATUS_SUCCESS): ?>
                                <h2>Данный объект проверен по данным ЕГРП</h2>
                                <ul class="publication-desc__list">
                                    <li class="publication-desc__li">
                                        Кадастровый номер: <?= $model->estate->cadastr_number ?>
                                    </li><li class="publication-desc__li">
                                        Собственник: <?php
                                        if (count($model->estate->owners) == 1){
                                            echo 'Один собственник';
                                        } else{
                                            echo 'Данным объектом владеет более одного собственника. Для исключения риска оспаривания остальными собственниками договора найма и его условий, необходимо чтобы Собственник получил с иных собственников нотариальное согласие на заключение договора найма и мог получать средства от сдачи квартиры в наем.';
                                        }
                                        ?>
                                    </li>
                                    <li class="publication-desc__li">
                                        Вид, номер и дата государственной регистрации права:
                                        <?= $model->estate->registration_law_kind ?>
                                        № <?= $model->estate->registration_law_number ?>
                                        от <?= $model->estate->registration_law_date ?>
                                    </li>
                                    <li class="publication-desc__li">
                                        Ограничение прав и обременение объекта недвижимости: <?= $model->estate->encumbrance ?>
                                    </li>
                                    <li class="publication-desc__li">
                                        Сведения о наличии решения об изъятии объекта недвижимости для государственных и муниципальных нужд: <?= $model->estate->seizure ?>
                                    </li>
                                    <li class="publication-desc__li">
                                        Сведения об осуществлении государственной регистрации прав без необходимого в силу закона согласия третьего лица, органа: <?= $model->estate->third_party_problem ?>
                                    </li>
                                </ul>
                            <?php else: ?>
                                <?php if ($model->estate->check_status == RealEstate::CHECK_STATUS_ERROR || $model->estate->check_status == RealEstate::CHECK_STATUS_NOT_RUN): ?>
                                    <h2>Данный объект НЕ проверен по данным ЕГРП</h2>
                                <?php else: ?>
                                    <h2>Идет проверка...</h2>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>


                        <div class="publication-desc__gallery js-gallery">
                            <h2 class="publication-desc__title _title">
                                Фотографии
                                <span><?= $model->getImages()->count() ?></span>
                            </h2>
                            <div class="publication-desc__photos">
                                
                                <?php
                                $i = 0;
                                foreach ($model->getImages()->where(['cover'=>0])->all() as $image) {
                                    /* @var $image app\models\AdImages */
                                    $figureOptions = [
                                        'class'     => 'publication-desc__photo',
                                        'itemprop'  => 'associatedMedia',
                                        'itemscope' => '',
                                    ];
                                    
                                    if ($i == 0) {
                                        Html::addCssClass($figureOptions, 'publication-desc__photo__big');
                                        
                                        $imageSize = [
                                            'width'  => 325,
                                            'height' => 230,
                                        ];
                                    } else {
                                        $imageSize = [
                                            'width'  => 192,
                                            'height' => 112,
                                        ];
                                    }
                                    
                                    $file          = $image->getFile();
                                    $imageFileSize = getimagesize($file->getPath(true));
                                    
                                    $img = Html::img($file->getImageUrl($imageSize), [
                                        'itemprop' => 'thumbnail',
                                    ]);
                                    
                                    $link = Html::a($img, $file->getImageUrl(), [
                                        'itemprop'  => 'contentUrl',
                                        'data-size' => $imageFileSize[0] . '.' . $imageFileSize[1],
                                    ]);
                                    
                                    echo Html::tag('figure', $link, $figureOptions);
                                    
                                    $i++;
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <!-- .publication-desc -->
                </div>
            </div>
            <!-- .publication-map -->
            <div class="publication-map" id="map">
                <h2 class="publication-desc__title publication-map__title _title">Месторасположение</h2>

                <div data-lat="55.915015" data-lng="37.6150949" data-address="<?= $realEstate->getFullAddress(); ?>"
                     class="js-publication-map"></div>
            </div>
            <!-- .publication-map -->
        </div>
    </div>

    <!-- gallery -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <!-- <button class="pswp__button pswp__button--share" title="Share"></button> -->
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->render('_share_publish_modal', [
        'model' => $model,
    ]) ?>
    <?= $this->render('_send_request_modal', [
        'model' => $model,
    ]) ?>
</section>







