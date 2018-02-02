<?php
/**
 * @var RealEstate[] $realEstate
 */

use app\models\RealEstate;
use yii\widgets\ActiveForm;
use app\models\Ads;

?>
<!-- shareProfile -->
<div style="display: none;">
    <div class="box-modal modal" id='shareProfile'>
        <div class="modal__close box-modal_close arcticmodal-close"></div>
        <div class="modal__wr">
            <h2 class="modal__title">Пригласить нанимателя</h2>
            <div class="modal__body">
                <?php
                $form = ActiveForm::begin([
                    'options'                => ['enctype' => 'multipart/form-data','class'=>'lk-form-popUp'],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => true,
                    'validateOnChange'       => true,
                    'validateOnBlur'         => false,
                    'validateOnSubmit'       => true,
                ]);
                ?>
                <h2>Пригласите ваших нанимателей лично!</h2>
                <?=
                $form->field($inviteCustomerForm, 'fio')->textInput([
                    'placeholder' => 'ФИО',
                    'class' => 'input--main',
                ])->label(false);
                ?>
                <?=
                $form->field($inviteCustomerForm, 'email')->textInput([
                    'placeholder' => 'E-mail',
                    'class' => 'input--main',
                ])->label(false);
                ?>
                <div class="selector selector-color--m js-selector">

                    <div class="selector__head js-selector-current-option-wrap">
                        <?=
                        $form->field($inviteCustomerForm, 'objectId')->hiddenInput([
                            'class' => 'js-selector-current-val',
                        ])->label(false);
                        ?>
                        <span class="selector__option-current js-selector-current">Выберите объект</span>
                        <span class="selector__option-icon"></span>
                    </div>

                    <?php if (count($realEstate) > 0): ?>
                        <ul class="selector__options-list js-selector-options">
                            <?php foreach ($realEstate as $reItem): ?>
                                <?php if ($reItem->ad && $reItem->ad->status == Ads::STATUS_ACTIVE): ?>
                                    <li id="reId_<?php echo $reItem->id ?>" data-option-name="<?= $reItem->ad->id ?>" class="selector__option js-selector-option">
                                        <?php echo $reItem->title ?>
                                        <small>
                                            <?php echo $reItem->city ?>,&nbsp
                                            <?php echo $reItem->street ?>
                                        </small>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </div>
                <button type="submit" class="btn btn--next">Пригласить нанимателя</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<!-- end shareProfile -->