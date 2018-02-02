


<?php

use app\components\helpers\CommonHelper;

CommonHelper::data()->setParam('headerText', $this->render('index/_header_text'));
?>
<span id="content-anchor"></span>

<section class="serv-feats-section">
    <div class="wrapper">
        <p class="title-h1 title-h1--bigger">
            Возможности сервиса
        </p>

        <div class="serv-feats">
            <div class="serv-feats__col">
                <a href="#!" class="serv-feats__item">
                    <div class="serv-feats__img-wr">
                        <img src="/images/svg/profile-ui.svg" alt="" width="154">
                    </div>
                    <div class="serv-feats__txt-wr">
                        <p class="title-h2">
                            Кредитная проверка жильцов
                        </p>
                        <div class="serv-feats__txt">
                            <p>
                                Проверяйте кредитную историю и платежеспособность будущих жильцов с помощью
                                наших скрининг-инструментов
                            </p>
                        </div>
                    </div>
                    <div class="serv-feats__bottom">
                        <span class="link link--crimson">Узнать больше</span>
                    </div>

                    <span class="serv-feats__arr serv-feats__arr--purple"></span>
                </a>
            </div>

            <div class="serv-feats__col">
                <a href="#!" class="serv-feats__item">
                    <div class="serv-feats__img-wr">
                        <img src="/images/svg/e-tracking.svg" alt="" width="146">
                    </div>
                    <div class="serv-feats__txt-wr">
                        <p class="title-h2">
                            Наглядное объявление
                        </p>
                        <div class="serv-feats__txt">
                            <p>
                                Поделитесь наглядным объявлением о сдаче в аренду непосредственно с
                                потенциальными жильцами, или опубликуйте на популярных сайтах об аренде
                                недвижимости
                            </p>
                        </div>
                    </div>
                    <div class="serv-feats__bottom">
                        <span class="link link--crimson">Узнать больше</span>
                    </div>
                    <span class="serv-feats__arr serv-feats__arr--yel"></span>
                </a>
            </div>

            <div class="serv-feats__col">
                <a href="#!" class="serv-feats__item">
                    <div class="serv-feats__img-wr">
                        <img src="/images/svg/paper-ui.svg" alt="" width="163">
                    </div>

                    <div class="serv-feats__txt-wr">
                        <p class="title-h2">
                            Электронный документооборот
                        </p>
                        <div class="serv-feats__txt">
                            <p>
                                Весь документооборот между собственником и нанимателем осуществляются в одном
                                месте. Это быстро и удобно
                            </p>
                        </div>
                    </div>
                    <div class="serv-feats__bottom">
                        <span class="link link--crimson">Узнать больше</span>
                    </div>
                    <span class="serv-feats__arr serv-feats__arr--green"></span>
                </a>
            </div>

            <div class="serv-feats__col">
                <a href="#!" class="serv-feats__item">
                    <div class="serv-feats__img-wr">
                        <img src="/images/svg/money-managment.svg" alt="" width="196">
                    </div>
                    <div class="serv-feats__txt-wr">
                        <p class="title-h2">
                            Онлайн-Оплата
                        </p>
                        <div class="serv-feats__txt">
                            <p>
                                Отправляем оплату за аренду напрямую со счета жильцов на ваш банковский счет. Автоматически, каждый расчетный период.
                            </p>
                        </div>
                    </div>
                    <div class="serv-feats__bottom">
                        <span class="link link--crimson">Узнать больше</span>
                    </div>
                    <span class="serv-feats__arr serv-feats__arr--purple"></span>
                </a>
            </div>

        </div>

    </div>
</section>

<?= $this->render('//layouts/_blocks/comms-slider') ?>

<div class="b-follow-l b-follow-l--grey">
    <div class="b-follow-l__wr">
        <div class="b-follow-l__item">
            <div class="b-follow-l__item-top">
                <div class="b-follow-l__item-t">
                    <a href="#!">
                        <img src="/images/svg/logo-icon-min.svg" alt="">
                        <div class="b-follow-l__txt">
                            <p class="b-follow-l__mt">АРЕНДАТИКА</p>
                            <p class="b-follow-l__tag">@arendatika</p>
                        </div>
                    </a>
                </div>
                <div class="b-follow-l__item-link">
                    <a href="#!" class="btn btn--follow-tw">Подписаться</a>
                </div>
            </div>
            <div class="b-follow-l__item-bottom">
                @Арендатика представляет дополнительные возможности для выставления счетов за аренду.
                <a href="#!" class="link">https://arenda.ru/12821</a>
            </div>
        </div>
        <div class="b-follow-l__item">
            <div class="b-follow-l__item-top">
                <div class="b-follow-l__item-t">
                    <a href="#!">
                        <img src="/images/svg/logo-icon-min.svg" alt="">
                        <div class="b-follow-l__txt">
                            <p class="b-follow-l__mt">АРЕНДАТИКА</p>
                            <p class="b-follow-l__tag">@arendatika</p>
                        </div>
                    </a>
                </div>
                <div class="b-follow-l__item-link">
                    <a href="#!" class="btn btn--follow-tw">Подписаться</a>
                </div>
            </div>
            <div class="b-follow-l__item-bottom">
                @Арендатика представляет дополнительные возможности для выставления счетов за аренду.
                <a href="#!" class="link">https://arenda.ru/12821</a>
            </div>
        </div>
    </div>
</div>

{signup_form}
