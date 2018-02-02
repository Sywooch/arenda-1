<?php
use app\components\extend\Controller;
use app\models\LeaseContracts;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$showEdit = true;
/** @var $model LeaseContracts */
if (count($model->participants) > 0) {
	foreach ($model->participants as $participnt) {
		if ($participnt->signed == 1) {
			$showEdit = false;
		}
	}
}
?>
<?php if (count($model->participants) == 0 OR $model->status == LeaseContracts::STATUS_CANCELED): ?>
	<?php
	$form = ActiveForm::begin([
		'enableClientValidation' => false,
		'enableAjaxValidation'   => false,
		'options'                => [
			'class' => 'lk-form lk-form--row-3-7 lk-form--row-p-20  lk-form--step-1',
		],
	]);
	?>
	<div class="js-members" style="display: none;">
		<style> div.btn.btn-lk-edit {
				margin-left: 16px;
			}

			.js-member-add--title span {
				display: none;
			} </style>
		<div class="lk-form__members">
			<?php
			echo $this->render('../form/_participant', [
				'form'         => $form,
				'model'        => $model,
				'participants' => $participants,
			]);
			?>
		</div>
		<div class="lk-form__wr--pw">
			<div class="lk-form__row lk-form--step-1__center">
				<div class="lk-form__col-r ">
					<button class="btn btn--add" type="submit">Пригласить!</button>
				</div>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
	<div class="clear clearfix"></div>
<?php endif; ?>
<div class="lk-temp__container lk-temp__container_shadow">
	<div class="lk-temp__section lk-temp__section_agreement ">
		<h3 class="lk-temp__title_small">Договор аренды жилого помещения</h3>
		<p class="_gray">№ <?= $model->id ?></p>
		<table class="lk-temp__grid lk-temp__grid_info lk-temp__grid_agreement">
			<tbody>
			<tr>
				<td>Недвижимость</td>
				<td>
					<p><?= $model->estate->getFullAddress() ?></p>
					<p class="_gray"><?= $model->estate->title ?></p>
				</td>
			</tr>
			<tr>
				<td>Сроки аренды</td>
				<td>
					<p>
						с
						<?php
						$startDate = $model->date_begin;
						$contents = [];
						$contents[] = date('d', $startDate);
						$contents[] = Controller::monthLabels(date('m', $startDate), 2);
						$contents[] = date('Y', $startDate);
						echo implode(' ', $contents);
						?>
						по
						<?php
						$endDate = (strtotime('+' . $model->lease_term . 'month', $model->date_begin));
						$contents = [];
						$contents[] = date('d', $endDate);
						$contents[] = Controller::monthLabels(date('m', $endDate), 2);
						$contents[] = date('Y', $endDate);
						echo implode(' ', $contents);
						?>
					</p>
					<p class="_gray"><?= LeaseContracts::getLeaseTermLabels($model->lease_term) ?></p>
				</td>
			</tr>
			<tr>
				<td>Участники</td>
				<td>
					<?php foreach ($model->participants as $participant): ?>
						<p>
							<a href="<?= $participant->user->getProfileUrl() ?>">
								<?= $participant->user->first_name; ?>
							</a>
						<p class="_gray"></p>
						</p>
					<?php endforeach; ?>
				</td>
			</tr>

			<tr>
				<td>Стоимость аренды</td>
				<td>
					<p><?= $model->getPricePerMonth() ?></p>
					<p class="_gray"><?= $model->getPricePerYear() ?></p>
				</td>
			</tr>

			<tr>
				<td>Оплата</td>
				<td>
					<p>По <?= $model->payment_date ?> числам месяца</p>
					<p class="_gray"><?php
						$startDate = $model->date_begin;
						$contents = [];
						$contents[] = date('d', $startDate);
						$contents[] = Controller::monthLabels(date('m', $startDate), 2);
						echo implode(' ', $contents);
						?> первая оплата</p>
				</td>
			</tr>

			<tr>
				<td>Депозит</td>
				<td>
					<p><?= $model->getDepositSum() ?></p>
					<p class="_gray"></p>
				</td>
			</tr>


			</tbody>
		</table>
	</div>
	<div class="lk-temp__section lk-temp__section_agreement">
		<?php if (in_array($model->status, [
			LeaseContracts::STATUS_ACTIVE,
			LeaseContracts::STATUS_SIGNED_BY_OWNER,
			LeaseContracts::STATUS_NEW,
			LeaseContracts::STATUS_CANCELED,
			LeaseContracts::STATUS_IN_DISABLE,
			LeaseContracts::STATUS_DISABLED,
		])): ?>
			<p class="_bold">Печатная версия договора</p>
			<p>
				<a href="<?php echo \yii\helpers\Url::to('/lease-contracts/download?contract_id=' . $model->id) ?>">
					Скачать договор
				</a>
			</p>
		<?php endif; ?>

		<?php if (count($model->participants) == 0): ?>

			<p>
				<a onclick="return confirm('Вы хотите удалить этот договор?');"
				   href="<?php echo \yii\helpers\Url::to('/lease-contracts/delete?id=' . $model->id) ?>">Удалить
					договор</a>
			</p>
			<button onclick="$('.js-members').toggle();" class="btn btn-gr lk-temp__button_y_agreement">
				Пригласить жильцов
			</button>
		<?php else: ?>
			<?php $signed = \app\models\LeaseContractParticipants::find()->where(['lease_contract_id'=>$model->id,'signed'=>1])->one(); ?>
			<?php if ($model->user_id == Yii::$app->user->id): ?>
				<?php if (in_array($model->status, [
					LeaseContracts::STATUS_NEW,
					LeaseContracts::STATUS_DRAFT,
					LeaseContracts::STATUS_CANCELED,
					//LeaseContracts::STATUS_IN_DISABLE,
					//LeaseContracts::STATUS_DISABLED,
				])): ?>
					<p>
						<a href="<?php echo \yii\helpers\Url::to('/lease-contracts/create?id=' . $model->id) ?>">Редактировать
							договор</a>
					</p>
				<?php endif; ?>
				<?php if ($model->status!=LeaseContracts::STATUS_SIGNED_BY_OWNER): ?>

				<?php endif; ?>
				<?php if ($signed==null): ?>
					<button class="btn btn-gr lk-temp__button_y_agreement" disabled="disabled">Ожидание подписания договора
					</button>
				<?php else: ?>
					<?php if (in_array($model->status, [
							LeaseContracts::STATUS_NEW,
							LeaseContracts::STATUS_DRAFT,
							//LeaseContracts::STATUS_CANCELED,
							//LeaseContracts::STATUS_IN_DISABLE,
							//LeaseContracts::STATUS_DISABLED,
						])): ?>
						<a href="<?php echo \yii\helpers\Url::to(['/lease-contracts/sign','id'=> $model->id]); ?>" class="btn btn-y lk-temp__button_y_agreement lk-temp__button_agreements--w">Подписать</a>
					<?php endif; ?>
				<?php endif; ?>
			<?php else: ?>
				<?php if ($signed!=null): ?>
					<?php if (!$model->status==LeaseContracts::STATUS_SIGNED_BY_OWNER): ?>
						<button class="btn btn-gr lk-temp__button_y_agreement" disabled="disabled">Ожидание подписания договора
						</button>
					<?php endif; ?>
				<?php else: ?>
					<p>
						<a href="<?php echo \yii\helpers\Url::to('/lease-contracts/create?id=' . $model->id) ?>">Редактировать
							договор</a>
					</p>
					<a href="<?php echo \yii\helpers\Url::to(['/lease-contracts/sign','id'=> $model->id]); ?>" class="btn btn-y lk-temp__button_y_agreement lk-temp__button_agreements--w">Подписать</a>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($model->status === LeaseContracts::STATUS_ACTIVE OR $model->status==LeaseContracts::STATUS_SIGNED_BY_OWNER): ?>
				<div style="display: none;">
					<div class="box-modal modal" id="_modal-contract-deactivate">

						<div class="modal__wr">
							<h2 class="modal__title modal--ok" id="_modal-contract-deactivate-text">
								По условиям подписанного договора №<?= $model->id ?> расторжение договора возможно при уведомлении второй
								стороны не позднее чем за "30" календарных дней.
								<br><br>
								Направить <?= (Yii::$app->user->id === $model->user->id) ? 'Нанимателю' : 'Собственнику'; ?> уведомление о расторжении договора?
							</h2>
							<div class="madal-form modal-delete">
								<a href="<?php echo \yii\helpers\Url::to('/lease-contracts/contract?id=' . $model->id . '&disable=yes'); ?>"
								   class="btn btn-y">Да</a>
								<button class="btn btn-pur arcticmodal-close">Нет</button>
							</div>
						</div>
					</div>
				</div>

				<script>
					function contractDeactivation() {
						$('#_modal-contract-deactivate').arcticmodal({
							closeOnEsc: false,
							closeOnOverlayClick: false,
						});
					}
				</script>

				<button onclick="contractDeactivation();" class="btn btn-y lk-temp__button_y_agreement">Расторгнуть
					договор
				</button>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ($model->status === LeaseContracts::STATUS_IN_DISABLE): ?>
			<button class="btn btn-gr lk-temp__button_y_agreement" disabled="disabled"><?=$model->status==LeaseContracts::STATUS_IN_DISABLE?LeaseContracts::getStatusLabels($model->status).' '.date('d.m.Y',$model->date_disable):LeaseContracts::getStatusLabels($model->status) ?>
			</button>
		<?php endif; ?>

		<?php if ($model->status === LeaseContracts::STATUS_DISABLED): ?>
			<button class="btn btn-gr lk-temp__button_y_agreement" disabled="disabled">Договор расторгнут
			</button>
		<?php endif; ?>

	</div>
</div>
