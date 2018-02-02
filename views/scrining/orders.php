<?php

use app\components\extend\Html;
use app\models\ScreeningRequest;
use app\models\ScreeningReport;

$this->title = 'Проверка данных';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $notvalid=false; ?>
<?php $i = 1; foreach ($reports as $model): ?>
    <?php if($i>1){ break;} ?>
	<?php if($model->status == ScreeningReport::STATUS_INVALID){ $notvalid=true; }?>
	<div class="lk-scrining__con lk-scrining__<?php echo $model->status == ScreeningReport::STATUS_VALID ? 'checkOk' : ($model->status == ScreeningReport::STATUS_PENDING ? 'check' : 'checkFailed'); ?>">
		<img src="<?php echo $model->user->getAvatarUrl(['width' => 70, 'height' => 70]); ?>" alt="">
		<h3><?php echo Html::encode($model->name_first); ?> <?php echo Html::encode($model->name_last); ?></h3>
        <!--<div class="valid--email">&nbsp;</div>-->
        <p class="request-status">
            <?php if ($model->status == ScreeningReport::STATUS_VALID): ?>
                <span class="valid--ok"><i class="iconic iconic--ok"></i>Проверка выполнена</span>
            <?php elseif ($model->status == ScreeningReport::STATUS_INVALID): ?>
                <span class="valid--invalid" style="color: #c43c35;">Данные не прошли проверку</span>
            <?php elseif ($model->status == ScreeningReport::STATUS_PENDING): ?>
                <span class="valid--proccess">Выполняется проверка...</span>
            <?php endif ?>
            <span class="valid--date"><?php echo date('d.m.Y',Html::encode($model->report_date)); ?></span>
        </p>
		<ul>
            <?php foreach ($reports as $model2): ?>
                <?php if ($model2->type == ScreeningReport::TYPE_CREDIT): ?>
                    <li>
                        <i class="iconic iconic<?php if($model2->status == ScreeningReport::STATUS_PENDING){ echo '--reload'; }else{ echo '--report'; }?>"></i>
                        <span>Проверка кредитной<br />истории</span>
                        <?php if ($model2->status == ScreeningReport::STATUS_VALID OR $model->status == ScreeningReport::STATUS_INVALID): ?>
                            <a class="document" href="credit?reportid=<?php echo $model2->id; ?>&reqid=<?php echo $model2->request_id; ?>">Скачать<i class="icon icon-arr_r_up"></i></a>
                        <?php endif ?>
                    </li>
                <?php endif; ?>
                <?php if ($model2->type == ScreeningReport::TYPE_BIO): ?>
                    <li>
                        <i class="iconic iconic--user"></i>
                        <span>Проверка личных<br />данных</span>
                        <?php if ($model2->status == ScreeningReport::STATUS_VALID OR $model2->status == ScreeningReport::STATUS_INVALID): ?>
                            <a class="document" href="biometric?reportid=<?php echo $model2->id; ?>&reqid=<?php echo $model2->request_id; ?>">Скачать<i class="icon icon-arr_r_up"></i></a>
                        <?php endif ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
		</ul>
	</div>
    <?php $i++;?>
<?php endforeach; ?>
<?php $notvalid=false; ?>
<?php if($notvalid): ?>
	<div style="text-align: center;"><a href="/scrining/create" class="btn btn-yell-bordered">Пройти проверку</a></div>
<?php endif; ?>

<?php foreach ($requests as $model): ?>
	<div class="lk-scrining__con lk-scrining__ok">
		<img src="<?php echo $model->user->getAvatarUrl(['width' => 70, 'height' => 70]); ?>" alt="">
		<h3><?php echo Html::encode($model->user->first_name); ?> <?php echo Html::encode($model->user->last_name); ?></h3>
		<p class="request-status">
			Заявка на проверку данных
		</p>
		<ul>
			<?php if ($model->type == ScreeningRequest::TYPE_CREDIT || $model->type == ScreeningRequest::TYPE_FULL): ?>
				<li>
					<i class="iconic iconic--report"></i>
					<span>Проверка кредитной<br />истории</span>
				</li>
			<?php endif; ?>
			<?php if ($model->type == ScreeningRequest::TYPE_BIO || $model->type == ScreeningRequest::TYPE_FULL): ?>
				<li>
					<i class="iconic iconic--user"></i>
					<span>Проверка личных<br />данных</span>
				</li>
			<?php endif; ?>
		</ul>
		<?php echo Html::a('Пройти проверку', ['create', 'type' => $model->type], [
			'class' => 'btn btn-y btn-normal',
			'style' => 'display:inline;',
		]); ?>
	</div>
    <?php $model->markViewed(); ?>
<?php endforeach; ?>