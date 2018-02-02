<?php
use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="title-row title-row--empty">
    <div class="title-row__title">
        <p class="h2">Общая информация</p>
    </div>
</div>
<div class="contant-row">
    <div class="col col-a">
        <?= $user->renderAvatar(['width' => 250, 'height' => 250,]); ?>
        <?php $currentUser = Yii::$app->user->identity; ?>
        <?php if (isset($currentUser->id) && ($user->id == $currentUser->id)): ?>
            <?php
            $form = ActiveForm::begin([
                'options'                => ['enctype' => 'multipart/form-data','class'=>'img_download'],
                'enableAjaxValidation'   => false,
                'enableClientValidation' => false,
                //'action'=>'profile-update',
            ]);
            ?>
                <?= Html::activeFileInput($model, 'photo',['id'=>'img_download','class'=>'img_download']) ?>
                <input name="only_file" type="text" value="yes">
                <label for="img_download" class="user_avatar-correct par-line-g-d">
                    <i class="icon icon-correct"></i>
                    <span>Обновить фото</span>
                </label>
            <?php ActiveForm::end(); ?>
        <?php endif ?>
    </div>
    <div class="col col-b">
        <h3 class="h3 h-mrg-b-15"><?= $user->fullName ?></h3>

        <ol class="inf_item">
            <?php if ($user->email != ''): ?>
                <li>
                    <a href="#!" class="link link--gray">
                        <i class="icon-mail"></i>
                        <span><?= $user->email; ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($user->phone != ''): ?>
                <li>
                    <a href="#!" class="link link--gray">
                        <i class="icon-phone"></i>
                        <span><?= $user->phone; ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($user->getDate('date_of_birth') != null): ?>
                <li>
                    <i class="icon-date"></i>
                    <span><?= $user->getDate('date_of_birth', 'd.m.Y'); ?> г.</span>
                </li>
            <?php endif; ?>
            <!--<li><i class="icon-map"></i><span class="c--gr">г. Москва, ул. Кутузовский проспект, 33</span></li>
            <li><i class="icon-pc"></i><span><a href="#">www.arenda.ru</a></span></li>-->
        </ol>
        <?php if ($info): ?>
            <?php if ($info->about != ''): ?>
                <p class="h-p h-mrg-t-40"><span><?= $info->getAttributeLabel('about'); ?>:</span></p>
                <p class="h-p"><?= $info->about; ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
