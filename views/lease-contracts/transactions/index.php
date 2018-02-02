<?php
use app\models\LeaseContracts;
use app\models\TransactionsLog;
?>
<div class="lk-temp__container lk-temp__container_shadow">
	<div class="lk-temp__section lk-temp__section_trans">
		<h3 class="lk-temp__title_small">Баланс</h3>
		<div class="lk-temp__title lk-temp__title_price">0 <img src="../images/rouble.png" alt=""></div>
		<div class="lk-temp__subtitle lk-temp__subtitle_price">Основан на сумме всех транзакции</div>
		<div class="lk-temp__buttonset">
			<button class="btn btn-normal btn-y lk-temp__button_y_trans js-modal-link" data-id-modal="transactions">+
				Расходы
			</button>
			<div class="lk-temp__buttonset--sep">
				<button class="btn btn-normal btn-w lk-temp__button_w_trans js-modal-link" data-id-modal="transactions-zach">+
					Зачисления</button>
				<button class="lk-temp__button_q tooltip" data-tooltip="Всплывающее окно">?</button>
			</div>
		</div>
		<div class="clearfix clear"></div>
		<br>
		<button class="btn btn-normal btn-y lk-temp__button_y_trans js-modal-link">
			Сделать перевод на карту
		</button>
	</div>
	<div class="lk-temp__section lk-temp__section_trans">
		<table class="lk-temp__grid lk-temp__grid_info lk-temp__grid_trans">
			<tbody>
			<tr>
				<td>Сроки аренды</td>
				<td>
					<p><?= date('d.m.Y', $model->date_begin) ?></p>
					<p class="_gray"><?= LeaseContracts::getLeaseTermLabels($model->lease_term) ?></p>
				</td>
			</tr>
			<tr>
				<td>Участники</td>
				<td>
					<?php foreach ($model->participants as $participant): ?>
						<a href="<?= $participant->user->getProfileUrl() ?>">
							<?= $participant->user->first_name; ?>
						</a>
					<?php endforeach; ?>
				</td>
			</tr>
			<tr>
				<td>Стоимость аренды</td>
				<td><?= number_format($model->price_per_month, 0, '.', ' ') ?> <span class="rub">Р</span> в мес.</td>
			</tr>

			</tbody>
		</table>
	</div>
</div>
<div class="lk-temp__container lk-temp__container_vertical">
	<?php if($waiting!=null):?>
		<table class="lk-temp__grid lk-temp__grid_pays">
			<thead>
			<tr>
				<th colspan="4">Предстоящие</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($waiting as $log):?>
				<tr>
					<td>
						<p class="_gray"><?=date('d M Y',strtotime($log->date_pay))?></p>
					</td>
					<td>
						<p><b><?=$log->title?></b></p>
						<p class="_gray"><?=TransactionsLog::getTypeLabels($log->type)?></p>
					</td>
					<td></td>
					<td>
						<?=$log->type==TransactionsLog::TYPE_RASXOD?'<p class="_gray _big">':'<p class="_green _big">+'?><?=$log->size?> <span class="rub">P</span></p>
					</td>
				</tr>
			<?php endforeach;?>
		<!--
    <tr>
        <td>
            <p class="_gray">22 янв 2016</p>
        </td>
        <td>
            <p><b>Плата за июль от Константина</b></p>
            <p class="_gray">Расходы</p>
        </td>
        <td>
            <div class="lk-temp__get-section">
                <div class="lk-temp__get-section-item">
                    <p class="_middle">Платежное поручение</p>
                    <img src="../images/table-trans-icon.png" alt="">
                </div>
                <button class="btn btn-normal btn-w lk-temp__button_w_trans">Принять</button>
            </div>

        </td>
        <td>
        </td>
    </tr>-->
		</tbody>
	</table>
	<?php endif;?>

	<?php if($successed!=null):?>
	<table class="lk-temp__grid lk-temp__grid_pays">
		<thead>
		<tr>
			<th colspan="4">Завершенные</th>
		</tr>
		</thead>
		<tbody>
			<?php foreach($successed as $log):?>
				<tr>
					<td>
						<p class="_gray"><?=date('d M Y',strtotime($log->date_pay))?></p>
					</td>
					<td>
						<p><b><?=$log->title?></b></p>
						<p class="_gray"><?=TransactionsLog::getTypeLabels($log->type)?></p>
					</td>
					<td></td>
					<td>
						<?=$log->type==TransactionsLog::TYPE_RASXOD?'<p class="_gray _big">':'<p class="_green _big">+'?><?=$log->size?> <span class="rub">P</span></p>
						<p class="_gray">0 руб. баланс</p>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php endif;?>

</div>
<!-- transactions -->
<div style="display: none;">
	<div class="box-modal modal" id='transactions'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title">Добавление расхода</h2>
			<div class="modal__body modal__body_transactions">
				<?php
				$form = \yii\widgets\ActiveForm::begin([
					'enableClientValidation' => true,
					'enableAjaxValidation'   => true,
					'options'                => [
						'class' => 'lk-form lk-form--row-3-7 lk-form--row-p-20  lk-form--step-1',
					],
				]);
				?>
				<div class="modal_transactions__row">
					<?= $form->field($rasxod,'title')->textInput(['placeholder'=>'Назначение платежа','class'=>'input--main modal_transactions__input-md'])->label(false); ?>
				</div>
				<div class="modal_transactions__row">
					<style>
						.modal_transactions__row .lk-form--datepicker-md {
							margin-right: 10px;
						}
					</style>
					<?= $form->field($rasxod, 'date_pay')->widget(\app\components\widgets\AirDatepicker\AirDatepicker::classname(), [
						'options' => [
							'class'       => 'input input modal_transactions__input-sm air-datepicker',
							'placeholder' => 'Дата оплаты',
							'value'       => null,//$rasxod->getDate('date', 'd.m.Y'),
						],
					])->label(false);
					?>
					<div class="lk-form--inline">
						<?= $form->field($rasxod,'size')->textInput(['placeholder'=>'Размер платежа','class'=>'input--main modal_transactions__input-sm modal_transactions__input-sm-r'])->label(false); ?>
						<?= $form->field($rasxod,'type')->hiddenInput()->label(false); ?>
					</div>

				</div>


				<button type="submit" class="btn btn-y modal_transactions__input__button">Добавить</button>
				<?php \yii\widgets\ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
<!-- transactions -->
<!-- transactions -->
<div style="display: none;">
	<div class="box-modal modal" id='transactions-zach'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title">Добавление зачисление</h2>
			<div class="modal__body modal__body_transactions">
				<?php
				$form = \yii\widgets\ActiveForm::begin([
					'enableClientValidation' => true,
					'enableAjaxValidation'   => true,
					'options'                => [
						'class' => 'lk-form lk-form--row-3-7 lk-form--row-p-20  lk-form--step-1',
					],
				]);
				?>
				<div class="modal_transactions__row">
					<?= $form->field($zach,'title')->textInput(['placeholder'=>'Назначение платежа','class'=>'input--main modal_transactions__input-md'])->label(false); ?>
				</div>
				<div class="modal_transactions__row">
					<style>
						.modal_transactions__row .lk-form--datepicker-md {
							margin-right: 10px;
						}
					</style>
					<?= $form->field($zach, 'date_pay')->widget(\app\components\widgets\AirDatepicker\AirDatepicker::classname(), [
						'options' => [
							'id'		  => 'datePay2',
							'class'       => 'input input modal_transactions__input-sm air-datepicker',
							'placeholder' => 'Дата оплаты',
							'value'       => null,//$rasxod->getDate('date', 'd.m.Y'),
						],
					])->label(false);
					?>
					<div class="lk-form--inline">
						<?= $form->field($zach,'size')->textInput(['placeholder'=>'Размер платежа','class'=>'input--main modal_transactions__input-sm modal_transactions__input-sm-r'])->label(false); ?>
						<?= $form->field($zach,'type')->hiddenInput()->label(false); ?>
					</div>

				</div>


				<button type="submit" class="btn btn-y modal_transactions__input__button">Добавить</button>
				<?php \yii\widgets\ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
<!-- transactions -->