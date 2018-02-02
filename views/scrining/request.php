<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\ScreeningRequest;
//use yii;

?>

<div class="page-scrining">
	<section class="screen-app wrapper-n cf">
		<h1 class="screen-app__title">Создание заявки на скрининг</h1>
		<?php $form = ActiveForm::begin([
			'enableClientValidation' => false,
			'enableAjaxValidation'   => false,
		]); ?>
		<div class="screen-app__body col col-1 col-1-no-bg">
			<!-- .screen-app-block -->
			<div class="screen-app-block">
				<h2 class="screen-app-block__title">1. Выберите метод проверки</h2>
				<div class="screen-app__panels">

					<!-- .screen-app-block__panel -->
					<div class="screen-app-panel js-screen-app-panel <?php if(isset($_GET['type'])){
						if($_GET['type']==3){ echo '_active'; }
					}else{
						echo '_active"';
					}?>">
						<input type="radio" class="_hide" name="type" value="<?php echo ScreeningRequest::TYPE_FULL; ?>"
							<?php if(isset($_GET['type'])){
								if($_GET['type']==3){ echo 'checked="checked"'; }
							}else{
								echo 'checked="checked"';
							}?> />
						<div class="screen-app-panel__top">
							<div class="screen-app-panel__icons">
								<?php include(Yii::getAlias("@webroot/images/svg/screen-app-icon1.svg")); ?>
								<?php include(Yii::getAlias("@webroot/images/svg/screen-app-plus.svg")); ?>
								<?php include(Yii::getAlias("@webroot/images/svg/screen-app-icon2.svg")); ?>
							</div>
							<div class="screen-app-panel__status">
								<?php include(Yii::getAlias("@webroot/images/svg/screen-status.svg")); ?>
							</div>
							<h3 class="screen-app-panel__title">
								Полная проверка
							</h3>
						</div>
						<div class="screen-app-panel__body">
<!--							<div class="screen-app-panel__cost">-->
<!--								-->
<!--								<span class="screen-app-panel__price_bonus">Бесплатно для собственников</span>-->
<!--							</div>-->
							<p class="screen-app-panel__text">
								Включает в себя проверку кредитной истории и личных данных нанимателя
							</p>
<!--							<p class="screen-app-panel__text">-->
<!--								Стоимость:<br>299 рублей (в случае двух отчетов)-->
<!--							</p>-->
<!--							<div class="screen-app-panel__payer">оплачивается нанимателем</div>-->
						</div>

					</div>
					<!-- .screen-app-block__panel -->

					<!-- .screen-app-block__panel -->
					<div class="screen-app-panel js-screen-app-panel <?php if(isset($_GET['type']) AND $_GET['type']==ScreeningRequest::TYPE_CREDIT){  echo '_active"'; }?>">
						<input type="radio" class="_hide" name="type" value="<?php echo ScreeningRequest::TYPE_CREDIT; ?>"
							<?php if(isset($_GET['type']) AND $_GET['type']==ScreeningRequest::TYPE_CREDIT){  echo 'checked="checked"'; }?>
						/>
						<div class="screen-app-panel__top">
							<div class="screen-app-panel__icons">
								<?php include(Yii::getAlias("@webroot/images/svg/screen-app-icon1.svg")); ?>
							</div>
							<div class="screen-app-panel__status">
								<?php include(Yii::getAlias("@webroot/images/svg/screen-status.svg")); ?>
							</div>
							<h3 class="screen-app-panel__title">
								Что такое проверка кредитной истории
							</h3>
						</div>
						<div class="screen-app-panel__body">
<!--							<div class="screen-app-panel__cost">-->
<!--								<span class="screen-app-panel__price_bonus">Бесплатно для собственников</span>-->
<!--							</div>-->
							<p class="screen-app-panel__text">
								Проверка вашей кредитной истории происходит онлайн на основании данных из нескольких российских баз кредитных историй. Вы и человек,  подавший вам данный запрос получите отчет вашей кредитной истории без указания данных о конкретных кредитах.
							</p>
						</div>

					</div>
					<!-- .screen-app-block__panel -->

					<!-- .screen-app-block__panel -->
<!--					<div class="screen-app-panel js-screen-app-panel --><?php //if(isset($_GET['type']) AND $_GET['type']==ScreeningRequest::TYPE_BIO){  echo '_active'; }?><!--">-->
<!--						<input type="radio" class="_hide" name="type" value="--><?php //echo ScreeningRequest::TYPE_BIO; ?><!--"-->
<!--							--><?php //if(isset($_GET['type']) AND $_GET['type']==ScreeningRequest::TYPE_BIO){  echo 'checked="checked"'; }?>
<!--						/>-->
<!--						<div class="screen-app-panel__top">-->
<!--							<div class="screen-app-panel__icons">-->
<!--								--><?php //include(Yii::getAlias("@webroot/images/svg/screen-app-icon2.svg")); ?>
<!--							</div>-->
<!--							<div class="screen-app-panel__status">-->
<!--								--><?php //include(Yii::getAlias("@webroot/images/svg/screen-status.svg")); ?>
<!--							</div>-->
<!--							<h3 class="screen-app-panel__title">-->
<!--								Что такое проверка личных данных-->
<!--							</h3>-->
<!--						</div>-->
<!--						<div class="screen-app-panel__body">-->
<!--							<div class="screen-app-panel__cost">-->
<!--								<span class="screen-app-panel__price_bonus">Бесплатно для собственников</span>-->
<!--							</div>-->
<!--							<p class="screen-app-panel__text">-->
<!--								Проверка личных данных осуществляется онлайн через базы данных из Федеральной Миграционной Службы, (ФМС), Федеральной Службы Судебных Приставов (ФССП), Федеральной Налоговой Службы (ФНС) и прочих баз данных.  Вы и человек, подавший вам данный запрос получите информацию о действительности вашего паспорта, его прописке и об отсутствии судебных исков.-->
<!--							</p>-->
<!--						</div>-->
<!---->
<!--					</div>-->
					<!-- .screen-app-block__panel -->
				</div>
			</div>
			<!-- .screen-app-block -->

            <!-- begin .screen-app-block__summ -->
            <div class="screen-app-summ">
                <button class="screen-app-summ__button">Стоимость: 299 Р</button>
                <div class="screen-app-summ__help-text">
                    Оплата будет списана с вашей карты
                </div>
            </div>
            <!-- end .screen-app-block__summ -->

			<!-- .screen-app-block -->
			<div class="screen-app-block">
				<div class="wrapper_f">

					<div class="screen-app-application">
						<h2 class="screen-app-block__title">2. Введите информацию нанимателя</h2>
						<p class="screen-app-block__subtitle">Мы отправим заявителям запрос по электронной почте, чтобы запустить свой собственный отчет.</p>

						<?php foreach ($models as $n => $model): ?>
							<div class="screen-app-application__form" data-index="<?php echo $n; ?>">
								<div class="screen-app-application__avatar">
									<?php include(Yii::getAlias("@webroot/images/svg/screen-app-placeholder.svg")); ?>
								</div>

								<div class="screen-app-application__form-wrapper">
									<div class="screen-app-application__form-group">
										<label><?php echo $model->getAttributeLabel('name_first'); ?></label>
										<?php echo $form->field($model, 'name_first')->textInput([
											'class'	=> '_input',
											'name'	=> sprintf('requests[%d][name_first]', $n),
											'id'	=> sprintf('requests-%d-name_first', $n),
										])->label(false); ?>
									</div>
									<div class="screen-app-application__form-group">
										<label><?php echo $model->getAttributeLabel('name_last'); ?></label>
										<?php echo $form->field($model, 'name_last')->textInput([
											'class'	=> '_input',
											'name'	=> sprintf('requests[%d][name_last]', $n),
											'id'	=> sprintf('requests-%d-name_last', $n),
										])->label(false); ?>
									</div>
									<div class="screen-app-application__form-group">
										<label><?php echo $model->getAttributeLabel('email'); ?></label>
										<?php echo $form->field($model, 'email')->textInput([
											'class'	=> '_mail _input',
											'name'	=> sprintf('requests[%d][email]', $n),
											'id'	=> sprintf('requests-%d-email', $n),
										])->label(false); ?>
									</div>
									<?php if ($n > 0): ?>
										<div class="screen-app-application__form-group">
											<label>&nbsp;</label>
											<div class="form-group field-screeningrequest-email required">
												<button class="btn btn-lk-edit" onclick="$(this).closest('.screen-app-application__form').remove();">Убрать</button>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>

						<a class="btn btn-g btn-full js-create-new-application">Добавить еще нанимателя</a>
						<br /><br />
						<div class="separator-l"></div>
						<div class="lk-form__row h-mrg-b-0">
							<div class="lk-form__col-r _w100--sc860">
								<button type='submit' class="btn btn--next">Далее</button>
							</div>
						</div>
					</div>
					
					<div class="screen-app-hint">
						<div class="screen-app-hint__icon">
							<i class="icon-lamp"></i>
						</div>
						<div class="screen-app-hint__text">
							<b>Как это работает?</b>
							<p>При запросе кредитный отчет или проверку, мы посылаем запрос по электронной почте к вашим заявителей. Они будет предложено создать учетную запись Уютное и безопасно вводить свои данные, чтобы подтвердить свою личность.</p>
						</div>
					</div>
				</div>

			</div>
			<!-- .screen-app-block -->

			
        </div>

		<?php ActiveForm::end(); ?>
        <div class="col col-2 col-i">
            <p class="h5 h-p">
                <i class="icon-lamp"></i>
                Это стандартная международная практика, что потенциальный нанематель оплачивает стоимость проведения проверки данных о себе. Если по каким-то причинам вам это не комфортно, то вы можете обсудить компенсацию вашей проверки со стороны проверяющего.
            </p>
        </div>
	</section>
</div>