<?php
use app\components\extend\Url;
?>
<div class="footer footer_small">
    <div class="btn_mobi">Карта сайта</div>
    <div class="wrapper-lk">
        <ul class="hf-l">
            <li class="hf-b">Информация</li>
            <li><a href="<?= Url::to('/ad'); ?>">Собственникам жилья</a></li>
            <li><a href="<?= Url::to('/profile'); ?>">Нанимателям</a></li>
            <li><a href="<?= Url::to('/how-it-works'); ?>">Как это работает</a></li>
            <li><a href="<?= Url::to('/prices'); ?>">Условия и цены</a></li>
            <li><a href="<?= Url::to('/reviews'); ?>">Отзывы</a></li>
        </ul>
        <ul class="hf-l">
            <li class="hf-b">Компания</li>
            <li><a href="<?= Url::to('/about-us'); ?>">Об Арендатике</a></li>
            <li><a href="<?= Url::to('/contacts'); ?>">Контакты</a></li>
            <li><a href="#">Условия	<br>предоставления услуг</a></li>
        </ul>
        <ul class="hf-l">
            <li class="hf-b">Помощь</li>
            <li><a href="<?= Url::to('/faq'); ?>">Вопрос ответ</a></li>
            <li><a href="#">Задать-вопрос</a></li>
        </ul>
        <ul class="hf-l">
            <li class="hf-b">Мы в соцсетях</li>
            <li>
                <a href="https://vk.com/club138082520" target='_blank' class="soc vk"><i></i></a>
                <a href="https://twitter.com/arenda" target='_blank' class="soc twit"><i></i></a>
                <a href="http://facebook.com/Арендатика-1282827785131872" target='_blank' class="soc fb"><i></i></a>
            </li>
        </ul>
        <ul class="hf-l footer__logo-c">
            <li>
                <a href="/" class="footer__logo">
                    <i>&copy; 2016</i>
                </a>
            </li>
            <li><span>Создание сайта</span><b></b><a href="https://nikoland.ru/">Nikoland</a></li>
        </ul>
    </div>
</div>

<?= $this->render('_footer/_popups'); ?>