<?php

use app\components\extend\Html;
use app\models\ScreeningRequest;
use app\models\ScreeningReport;

$status = $model->getStatus();
?>
<div class="lk-scrining__con lk-scrining__<?php echo $status == ScreeningRequest::STATUS_VALID ? 'checkOk' : ($status == ScreeningRequest::STATUS_PROCESSING ? 'check' : 'ok'); ?>">
	<?php if ($model->reporter): ?>
		<img src="<?php echo $model->reporter->getAvatarUrl(['width' => 70, 'height' => 70]); ?>" alt="">
	<?php else: ?>
		<img src="/images/svg/screen-app-placeholder.svg" alt="">
	<?php endif ?>
	<h3><?php echo Html::encode($model->name_first); ?>
		<?php echo Html::encode($model->name_last); ?>		
	</h3>
	<div class="valid--email"><?php if ($model->reporter): ?><?php echo Html::encode($model->reporter->email); ?><?php endif ?></div>
	<p class="request-status">
		<?php if ($status == ScreeningRequest::STATUS_VALID): ?>
			<span class="valid--ok"><i class="iconic iconic--ok"></i>Проверка выполнена</span>
		<?php elseif ($status == ScreeningRequest::STATUS_INVALID): ?>
			<span class="valid--invalid" style="color: #c43c35;">Проверка не прошло успешно</span>
		<?php elseif ($status == ScreeningRequest::STATUS_PROCESSING): ?>
			<span class="valid--proccess">Выполняется проверка...</span>
		<?php else: ?>
			<span class="valid--new">Заявка отправлена</span>
		<?php endif ?>
		<span class="valid--date"><?php echo date('d.m.Y',Html::encode($model->request_date)); ?></span>

	</p>
	<ul>
		<?php if ($model->type == ScreeningRequest::TYPE_CREDIT || $model->type == ScreeningRequest::TYPE_FULL): ?>
			<li>
				<i class="iconic iconic<?php if($status == ScreeningRequest::STATUS_PROCESSING){ echo '--reload'; }else{ echo '--report'; }?>"></i>
				<span>Проверка кредитной<br />истории</span>
				<?php if (isset($model->creditReport) AND ($model->creditReport->status == ScreeningReport::STATUS_VALID OR $model->creditReport->status == ScreeningReport::STATUS_INVALID)): ?>
					<a class="document" href="credit?reportid=<?php echo isset($model->bioReport->id)?$model->bioReport->id:''; ?>&reqid=<?php echo isset($model->bioReport->request_id)?$model->bioReport->request_id:''; ?>">Скачать<i class="icon icon-arr_r_up"></i></a>
				<?php endif ?>
			</li>
		<?php endif; ?>
		<?php if ($model->type == ScreeningRequest::TYPE_BIO || $model->type == ScreeningRequest::TYPE_FULL): ?>
			<li>
				<i class="iconic iconic--user"></i>
				<span>Проверка личных<br />данных</span>
				<?php if (isset($model->creditReport) AND ($model->bioReport->status == ScreeningReport::STATUS_VALID OR $model->creditReport->status == ScreeningReport::STATUS_INVALID)): ?>
					<a class="document" href="biometric?reportid=<?php echo isset($model->bioReport->id)?$model->bioReport->id:''; ?>&reqid=<?php echo isset($model->bioReport->request_id)?$model->bioReport->request_id:''; ?>">Скачать<i class="icon icon-arr_r_up"></i></a>
				<?php endif ?>
			</li>
		<?php endif; ?>
	</ul>
</div>