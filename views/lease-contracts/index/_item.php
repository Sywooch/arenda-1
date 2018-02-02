<?php
/**
 * @var LeaseContracts $model
 */

use app\components\extend\Html;
use app\models\LeaseContracts;
use app\models\RealEstate;

/** @var \app\models\User $user */
$user = Yii::$app->user->identity;

$readOnly = (isset($readOnly)) ? $readOnly : false;

?>
<div class="lk-temp__item lk-temp__item_agreements">
	<div class="lk-temp__header lk-temp__header_agreements">
		<div class="lk-temp__section_agreements">
			<h2 class="lk-temp__title_agreements">
				<?php if ($readOnly): ?>
					<?= $model->estate->title; ?>
				<?php else: ?>
					<?php if ($model->user_id == $user->id): ?>
						<?= Html::a($model->estate->title, ['contract', 'id' => $model->id], [
							'data-pjax' => 0,
						]) ?>
					<?php else: ?>
						<?php if (!$model->isSignedByUser($user->id)): ?>
							<?php if (isset($user->passport->verify) AND $user->passport->verify==\app\models\UserPassport::VERIFY_VERIFIED): ?>
								<?= Html::a($model->estate->title, ['sign', 'id' => $model->id], [
									'data-pjax' => 0,
								]) ?>
							<?php else: ?>
								<?= Html::a($model->estate->title, ['#!'], [
									'class'     => 'js-modal-link',
									'data-pjax' => 0,
									'data-id-modal'=>'canVerifyPopup',
									'onclick'	=>'return false;',
								]) ?>
							<?php endif; ?>
						<?php else: ?>
							<?= Html::a($model->estate->title, ['contract', 'id' => $model->id], [
								'data-pjax' => 0,
							]) ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				/*if (LeaseContractParticipants::find()->where(['lease_contract_id'=>$model->id, 'signed' => 1])->all()!=null AND $model->status != LeaseContracts::STATUS_DISABLED) {
					echo '<span class="lk-temp__status lk-temp__status_agreements _default">Договор подписан</span>';
				} elseif ($model->status == LeaseContracts::STATUS_NEW AND $model->participants==null) {
					echo '<span class="lk-temp__status lk-temp__status_agreements _default">Договор №'.$model->id.'</span>';
				} elseif ($model->status == LeaseContracts::STATUS_NEW AND $model->participants!=null) {
					echo '<span class="lk-temp__status lk-temp__status_agreements _default">Договор направлен на подписиние нанимателю</span>';
				} elseif($model->status == LeaseContracts::STATUS_ACTIVE) {
					echo '<span class="lk-temp__status lk-temp__status_agreements _default">Договор подписан нанимателем</span>';
				} elseif ($model->status == LeaseContracts::STATUS_DISABLED){
					echo '<span class="lk-temp__status lk-temp__status_agreements _default">Договор расторгнут</span>';
				} elseif ($model->status == LeaseContracts::STATUS_CANCELED  OR $model->participants==null){
					echo '<span class="lk-temp__status lk-temp__status_agreements _default">Договор №'.$model->id.'</span>';
				}*/

				$statusHtmlOptions = [
					'class' => 'lk-temp__status lk-temp__status_agreements _default',
					'style'=>$model->status==LeaseContracts::STATUS_IN_DISABLE?'width: 335px;':'',
				];

				if ($model->status == LeaseContracts::STATUS_ACTIVE) {
					// Если статус "Подписан обеими сторонами" - выделяем ярким фоном
					Html::addCssStyle($statusHtmlOptions, 'background: #d8188b;');
				}
                if(($model->status==LeaseContracts::STATUS_DRAFT OR $model->status==LeaseContracts::STATUS_NEW) AND $model->isSignedByUser(null)){
                    $stat = 'Подписан нанимателем';
                }else{
                    $stat = $model->status==LeaseContracts::STATUS_IN_DISABLE?LeaseContracts::getStatusLabels($model->status).' '.date('d.m.Y',$model->date_disable):LeaseContracts::getStatusLabels($model->status);
                }
				echo Html::tag('span', $stat, $statusHtmlOptions);
				?>
			</h2>
		</div>
		<div class="lk-temp__section_agreements" <?php if ($model->status == LeaseContracts::STATUS_DISABLED AND $model->user_id == $user->id): ?>style="min-width: 305px;"<?php endif; ?>>
			<?php if (!$readOnly): ?>
				<?php if ($model->user_id == $user->id): ?>
					<?php if ($model->status == LeaseContracts::STATUS_DISABLED OR $model->status == LeaseContracts::STATUS_CANCELED): ?>
						<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
							'class'     => 'btn btn-y lk-temp__button_payments lk-temp__button_agreements--w',
							'data-pjax' => 0,
							'onclick'=>'return confirm("Вы хотите удалить этот договор?");',
						]); ?>&nbsp;
					<?php endif; ?>
					<?php if ($model->status != LeaseContracts::STATUS_CANCELED): ?>
						<?= Html::a('Посмотреть всю информацию', ['contract', 'id' => $model->id], [
							'class'     => 'btn btn-y lk-temp__button_payments lk-temp__button_agreements--w',
							'data-pjax' => 0,
						]) ?>
					<?php endif; ?>
				<?php else: ?>
					<?php if ($model->status == LeaseContracts::STATUS_CANCELED): ?>
						<?= Html::a('Удалить', ['deletepart', 'id' => $model->id], [
							'class'     => 'btn btn-y lk-temp__button_payments lk-temp__button_agreements--w',
							'data-pjax' => 0,
							'onclick'=>'return confirm("Вы хотите удалить этот договор?");',
						]); ?>
					<?php else: ?>
						<?php if (!$model->isSignedByUser($user->id)): ?>
							<?php if ($model->estate->check_status == RealEstate::CHECK_STATUS_SUCCESS): ?>
							    <?php if (isset($user->passport->verify) AND $user->passport->verify==\app\models\UserPassport::VERIFY_VERIFIED): ?>
    								<?= Html::a('Подписать договор', ['sign', 'id' => $model->id], [
    									'class'     => 'btn btn-y lk-temp__button_payments lk-temp__button_agreements--w',
    									'data-pjax' => 0,
    								]) ?>
    							<?php else: ?>
    								<?= Html::a('Подписать договор', ['#!'], [
    									'class'     => 'btn btn-y lk-temp__button_payments lk-temp__button_agreements--w js-modal-link',
    									'data-pjax' => 0,
    									'data-id-modal'=>'canVerifyPopup',
    									'onclick'	=>'return false;',
    								]) ?>
    							<?php endif; ?>
							<?php else: ?>
                                <?php if ($model->estate->check_status == RealEstate::CHECK_STATUS_ERROR): ?>
                                    Объект не прошел проверку
                                <?php else: ?>
                                    Объект проходит проверку...
                                <?php endif; ?>
							<?php endif; ?>
						<?php else: ?>
							<?= Html::a('Посмотреть всю информацию', ['contract', 'id' => $model->id], [
								'class'     => 'btn btn-y lk-temp__button_payments lk-temp__button_agreements--w',
								'data-pjax' => 0,
							]) ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php endif; ?>
		</div>
	</div>

	<div class="lk-temp__footer lk-temp__footer_agreements">
		<div class="lk-temp__section_agreements">
			<h3 class="lk-temp__title_agreements--sm">Баланс</h3>
			<div class="lk-temp__title lk-temp__title_price--sm">0 <span class="_big rub">Р</span></div>
			<p class="_gray">Основан на сумме всех транзакции</p>
		</div>
		<div class="lk-temp__section_agreements">
			<table class="lk-temp__grid lk-temp__grid_info lk-temp__grid_agreements">
				<tbody>
				<tr>
					<td>Плата</td>
					<td><?= number_format($model->price_per_month, 0, '.', ' ') ?> <span class="rub">Р</span></td>
				</tr>
				<tr>
					<td>Жильцы</td>
					<td>
						<?php
						$participants = $model->participants;
						$parts = [];

						foreach ($participants as $participant) {
							$parts[] = Html::a($participant->user->first_name, $participant->user->getProfileUrl(), [
								'target'    => '_blank',
								'data-pjax' => 0,
							]);
						}

						echo implode(', ', $parts);
						?>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>