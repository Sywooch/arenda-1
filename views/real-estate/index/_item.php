<?php
/**
 * @var RealEstate $model
 */
use app\components\extend\Html;
use app\components\extend\Url;
use app\models\LeaseContracts;
use app\models\Ads;
use app\models\RealEstate;

?>
<!-- .lk-realty -->
<div class="lk-realty lk-realty--status-success">
	<div class="lk-realty__head">
		<div class="lk-realty__h-main lk-realty__h-txt">
			<h5 class="lk-realty__h-title"><?= $model->title; ?></h5>
			<span class="lk-realty__h-desc"><?= $model->getFullAddress() ?></span>
		</div>
		<div class="lk-realty__h-aside">
			<div class="btns-line">
				<?php if ($model->ad && $model->ad->status == Ads::STATUS_ACTIVE AND isset($model->user->passport->verify) AND $model->user->passport->verify==\app\models\UserPassport::VERIFY_VERIFIED): ?>
					<?=
					Html::a('Пригласить нанимателя', '#!', [
						'class'   => 'btn btn-normal btn-w js-modal-link', //($model->check_status != RealEstate::CHECK_STATUS_SUCCESS) ? 'btn btn-normal btn-w' : 'btn btn-normal btn-w js-modal-link',
						'title'   => 'Пригласить нанимателя',
						'onclick' => '$("#reId_' . $model->primaryKey . '").click();$("#reId_' . $model->primaryKey . '").click();',//($model->check_status != RealEstate::CHECK_STATUS_SUCCESS) ? 'return false;' : '$("#reId_' . $model->primaryKey . '").click();$("#reId_' . $model->primaryKey . '").click();',
						'data'    => [
							//'href' => Url::to(['invitecustomer', 'id' => $model->primaryKey]),
							//'pjax' => 0,
							'id-modal' => 'shareProfile',
						],
                        //'disabled'=> ($model->check_status != RealEstate::CHECK_STATUS_SUCCESS) ? ' disabled' : ''
					]);
					?>
				<?php endif; ?>
				<?=
				Html::a('Изменить объект', '#!', [
					'class' => 'btn btn-normal btn-w js-modal-link-ajax',
					'title' => 'Изменить объект',
					'data'  => [
						'href' => Url::to(['update', 'id' => $model->primaryKey]),
						'pjax' => 0,
					],
				]);
				?>
				<?=
				Html::a('Удалить', '#!', [
					'class' => 'btn btn-normal btn-gr js-modal-link-ajax',
					'title' => 'Удалить',
					'data'  => [
						'href' => Url::to(['delete', 'id' => $model->primaryKey]),
						'pjax' => 0,
					],
				]);
				?>
			</div>
		</div>

	</div>
	<div class="lk-realty__body">
		<div class="img-box"
		     style="background-image: url('<?= $model->getCoverUrl(['width' => 280, 'height' => 195]); ?>');">
            <span class="img-box__label">
                <span class="iconic iconic--photo"></span>
	            <?= $model->ad ? $model->ad->getImages()->count() : ''; ?>
            </span>
            <div class="processing-status">
                <div class="processing-status__icon processing-status__icon--<?php
                if($model->check_status==RealEstate::CHECK_STATUS_SUCCESS){
                    echo 'passed';
                }elseif($model->check_status==RealEstate::CHECK_STATUS_IN_PROCESS){
                    echo 'during';
                }else{
                    echo 'no';
                }
                ?>"></div>
                <div class="processing-status__help-text">
                    <div class="processing-status__title"><?php
                        if($model->check_status==RealEstate::CHECK_STATUS_SUCCESS){
                            echo 'Объект успешно прошел';
                        }elseif($model->check_status==RealEstate::CHECK_STATUS_IN_PROCESS){
                            echo 'Объект на проверку';
                        }else{
                            echo 'Объект не прошел проверку';
                        }
                        ?></div>
                    <div class="processing-status__text">
                        Проверка объекта — позволяет вам быть увереным в надежности сделки
                    </div>
                </div>
            </div>
		</div>
		<div class="lk-realty__props">
			<?=
			$this->render('_item/_ad', [
				'model' => $model,
			]);
			?>
			<div class="lk-realty__p-item lk-realty__p-item--mob-block">
				<div class="lk-realty__p-name">
					Заявки
				</div>
				<div class="lk-realty__p-content">
					<?php if ($model->ad): ?>
						<p class="lk-realty__p-subtitle">
							Всего <?= $model->ad ? $model->ad->getApplicationsCount() : 0 ?>
							<?php
							$newApplications = $model->ad->getNewApplicationsCount();
							if ($newApplications > 0) {
								echo Html::tag('span', $newApplications, ['class' => 'label-rect']);
							}
							?>
						</p>
					<?php else: ?>
						<p class="lk-realty__p-note">
							Создайте объявление для того, чтобы иметь возможность опубликовать его на сайтах
							недвижимости и получать заявки
						</p>
					<?php endif; ?>
					<p>
						<!--Заявки не принимаются-->
					</p>
				</div>
			</div>
			<div class="lk-realty__p-item lk-realty__p-item--mob-block">
				<div class="lk-realty__p-name">
					Договор
				</div>
				<div class="lk-realty__p-content">
					<?php
					$contract = LeaseContracts::find()
						->where([
							'real_estate_id' => $model->id,
							'user_id'        => $model->user_id,
						])
						->andWhere(['!=', 'status', LeaseContracts::STATUS_DISABLED])
						->orderBy('id DESC')
						->one();

					$contractHistory = LeaseContracts::find()
						->where([
							'real_estate_id' => $model->id,
							'user_id'        => $model->user_id,
						])
						->andWhere(['status' => LeaseContracts::STATUS_DISABLED])
						->exists();
					?>
					<?php if ($contract != null): ?>
						<?php if ($contract->status == LeaseContracts::STATUS_DRAFT): ?>
							<?=
							Html::a('Черновик', ['/lease-contracts/create', 'eId' => $model->primaryKey], [
								'class' => 'btn btn-normal btn-normal--vert-sm btn-bl',
								'data'  => [
									'pjax' => 0,
								],
							]);
							?>
						<?php else: ?>
                            <?php if(($contract->status==LeaseContracts::STATUS_DRAFT OR $contract->status==LeaseContracts::STATUS_NEW) AND $contract->isSignedByUser(null)){
                                $stat = 'Подписан нанимателем';
                            }else{
                                $stat = $contract->status == LeaseContracts::STATUS_IN_DISABLE ? LeaseContracts::getStatusLabels($contract->status).' '.date('d.m.Y',$contract->date_disable):LeaseContracts::getStatusLabels($contract->status);
                            }?>
							<?= '<p class="lk-realty__p-note">' .$stat. '</p>'; ?>
							<?=
							Html::a('Посмотреть договор', ['/lease-contracts/contract', 'id' => $contract->primaryKey], [
								'class' => 'btn btn-normal btn-normal--vert-sm btn-bl',
								'data'  => [
									'pjax' => 0,
								],
							]);
							?>
						<?php endif; ?>
					<?php else: ?>
						<?=
						Html::a('Создать договор', ['/lease-contracts/create', 'eId' => $model->primaryKey], [
							'class' => 'btn btn-normal btn-normal--vert-sm btn-bl',
							'data'  => [
								'pjax' => 0,
							],
						]);
						?>
					<?php endif; ?>
					<?php
					if ($contractHistory) {
						// У нас есть расторгнутые договора - показываем кнопку
						echo Html::a('История договоров', ['/lease-contracts/history', 'eId' => $model->primaryKey], [
							'class' => 'btn btn-normal btn-normal--vert-sm btn-bl',
							'data'  => [
								'pjax' => 0,
							],
						]);
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div><!-- /.lk-realty -->
