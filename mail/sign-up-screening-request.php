<?php
use app\components\helpers\CommonHelper;
use app\models\ScreeningRequest;
use app\components\extend\Html;
use app\components\extend\Url;
?>
<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; height: 100px; width: 99%; text-align: center;">
    <tbody><tr>
        <td style="text-align: center;">
            <?php echo Html::encode($request->user->first_name); ?>
            <?php echo Html::encode($request->user->last_name); ?>,
            (<?php echo Html::encode($request->user->email);  echo !empty($request->user->phone)?', '.Html::encode($request->user->phone):''; ?>)
            просит Вас дать согласие на проверку ваших данных на платформе управления недвижимостью Арендатика (<?php echo CommonHelper::data()->getParam('tld', 'arenda.ru') ?>)
        </td>
    </tr>
    <tr>
        <td style="text-align: left;">
            <div>Запрашиваемый тип проверки:</div>
            <ul><?php if(count($request->getTypeNames())>0){
                    foreach ($request->getTypeNames() as $type){
                        echo '<li>'.$type.'</li>';
                    }
                } ?></ul>
        </td>
    </tr>
    <tr><td style="text-align: center;">
            Если вы согласны пройти проверку, то подтвердите, пожалуйста, ваше согласие на сайте Арендатика
        </td></tr>
    <tr><td>
            <?php echo Html::a('Пройти проверку', Url::to(['scrining/create', 'type' => $request->type], true)); ?>
        </td></tr>
    </tbody>
</table>