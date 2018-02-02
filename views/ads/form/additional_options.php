<?php

/**
 * @var $model Ads
 * @var $this \yii\web\View
 */

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\Ads;
use app\models\AdBoard;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;
use yii\helpers\ArrayHelper;
use app\models\User;

$this->registerJsFile('https://demo-v-jet.inplat.ru/static/js/widget_tsp.js');
?>

<?php $boards = AdBoard::getAvailable(); ?>
<?php $user = User::findOne(yii::$app->user->id);?>
<?php if (count($boards)): ?>
    <div class="js-calc-cost realcheck">
        <?= $form->field($model, 'place_add_to')->error(false)->checkboxList(ArrayHelper::map($boards, 'id',
            'name'), [
            'unselect' => false,
            'item'     => function ($index, $label, $name, $checked, $value) use ($boards, $model, $user) {
                $contents = [];
                $contents[] = Html::beginTag('div',['class'=>'realcheck__col']);
                $contents[] = '<div class="realcheck__img">
                <img src="/images/ao/realcheck-'.$value.'.png" alt="'.$name.'">
            </div>';
                $id = 'ssm_' . $index;
                $checkBoxParams = [
                    'id'         => $id,
                    'value'      => $value,
                    'class'      => 'js-checkbox',
                    'data-payed' => 0,
                    'data-cost'  => floatval($boards[$value]['std_price']),
                ];

                // Первый раз ставим галочки везде
                if (empty($model->place_add_to) AND $model->isNewRecord) {
                    //$checked = true;
                }


                $payedText = '';
                if ($model->pay()->serviceIsPay($value)) {
                    $payedText = ' (Оплачено)';
                    $checkBoxParams['data-payed'] = 1;
                    //$checked = true;
                }

                $contents[] = '<div class="realcheck__title Check_fam Check_fam--sq">';
                if( $model->isPublished($model->id,$value) AND ($user->feed_free_date == null OR $user->feed_free_date > time('now'))){
                    $payedText ='<div class="realcheck__info">
                <div class="realcheck__info-date">Публикация до '.date('d.m.Y',$user->feed_free_date==null?strtotime('+7 day'):$user->feed_free_date).'</div>
                <div class="realcheck__info-link"><a data-id-modal="confirmUnpublishPopup" style="border-bottom:none!important;" class="link link--blue js-modal-link" onclick="$(\'.unpublish_ad\').val('.$model->id.'); $(\'.unpublish_board\').val('.$value.');">Снять с публикации</a></div>
            </div>';
                    //$checkBoxParams['data-payed'] = 1;
                    //$checked = true;
                    $checkBoxParams['readonly'] = 'readonly';
                    //$checkBoxParams['disabled'] = 'disabled';
                    $contents[] = Html::hiddenInput($name, $checked, $checkBoxParams);
                }



                $contents[] = Html::checkbox($name, $checked, $checkBoxParams);
                $contents[] = Html::label(Html::tag('i', '', ['class' => 'Check_fam__view']) . $label, $id);
                $contents[] = '</div>';
                $contents[] = '<div class="realcheck__price">' . floatval($boards[$value]['std_price']) . ' <span class="rub">Р/месяц</span></div>';
                $contents[] = $payedText;
                $contents[] = Html::endTag('div');
                return implode("\n", $contents);
            },
        ])->hint(false); ?>
        <?php if ($model->hasErrors('place_add_to')): ?>
            <?= Html::error($model, 'place_add_to', ['tag' => 'p', 'class' => 'help-block help-block-error']) ?>
            <br/>
            <p>Пожалуйста, исправьте неточности в адресе, чтобы избежать проблем с публикацией объявлений на сторонних
                сервисах.</p>
            <br/>
            <?= $this->render('estate_address', [
                'form' => $form,
                'model' => $model->estate,
            ]); ?>
        <?php endif; ?>
        <div class="realcheck__after">
            <p style="<?= $model->pay()->statusPaid() ? '' : 'display:none' ?>"
               class="js-pay-message"><?= $model->pay()->paidMessage() ?></p>
            <?php if( $user->feed_free_date == null OR $user->feed_free_date > time('now')): ?>
                <span class="realcheck__after-sum js-cost-result result-box__t">Стоимость: <i class='js-cost'>0</i> руб</span>
                <span class="realcheck__after-alert"><i class="realcheck__after-alert--ex">!</i>Первые 7 дней размещения объявления на всех площадках - бесплатно</span>
                <a class="btn btn--next inplat-pay" data-object-id="<?= $model->id ?>" data-method="modal"
                   style="display:none;" data-pjax="0">
                </a>
            <?php else: ?>
                <span class="realcheck__after-sum js-cost-result result-box__t">Стоимость: <i class='js-cost'>0</i> руб</span>
                <a class="btn btn--next inplat-pay" data-object-id="<?= $model->id ?>" data-method="modal"
                   style="<?= !$model->pay()->statusNo() ? 'display:none' : '' ?>" data-pjax="0">Оплатить
                </a>
            <?php endif ?>

        </div>
</div>
    <!-- confirm -->
    <div style="display: none;">
        <div class="box-modal modal" id='confirmUnpublishPopup'>
            <div class="modal__close box-modal_close arcticmodal-close"></div>
            <div class="modal__wr">
                <h2 class="modal__title modal--delete">Вы действительно хотите снять объявление с публикации. Повторная активация осуществляется на платной основе.</h2>
                <div action="#" class="madal-form modal-delete">
                    <input type="hidden" class="unpublish_ad">
                    <input type="hidden" class="unpublish_board">
                    <button type="button" class="btn btn-y unbuplishIt">Cнять с публикации</button>
                    <div class="btn btn-pur arcticmodal-close">Отменить</div>
                </div>
            </div>
        </div>
    </div>
    <!-- end confirm -->
    <!-- confirm -->
    <div style="display: none;">
        <div class="box-modal modal" id='confirmFeedPopup'>
            <div class="modal__close box-modal_close arcticmodal-close"></div>
            <div class="modal__wr">
                <h2 class="modal__title modal--delete">Вы даете согласие на размещения объявления на площадках недвижимости</h2>
                <div action="#" class="madal-form modal-delete">
                    <button type="button" class="btn btn-y arcticmodal-close" onclick="$('#w0').submit(); $('.confirmFeedPopup').prop('disabled',true);">Подтвердить</button>
                    <div class="btn btn-pur arcticmodal-close">Отменить</div>
                </div>
            </div>
        </div>
    </div>
    <!-- end confirm -->
<?php endif; ?>

<style>
	.disabled {
		background: #ccc;
	}
</style>
<?php
$this->registerJs(<<<JS
    $('.unbuplishIt').click(function() {
         $(this).prop('disabled',true);
         $.ajax({
             url: '/ads/unpublish?ad='+$('.unpublish_ad').val()+'&board='+$('.unpublish_board').val(),
             success: function(){
                location.reload();
             }
         });
    });     
JS
);

?>