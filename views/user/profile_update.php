<?php

use yii\bootstrap\ActiveForm;
use app\components\extend\Url;
use app\components\extend\Html;
use app\components\widgets\SideHelper;
use app\models\UserPassport;

/* @var $form yii\widgets\ActiveForm */


/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => Url::to(['/user/profile'])];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование'];
?>
<div class="wrapper-lk">
	<div class="lk-backTitle">
		<a href="<?= Url::to(['/user/profile']) ?>" class="lk-temp__back">
			Ваш профиль
		</a>
		<h1>Редактирование профиля
			<span class="fr">
				<?php if ($passport->verify==UserPassport::VERIFY_VERIFIED): ?>
					<div class="dashboard-contacts__item">
						<span class="icon-verif-sm"></span>
						<span class="_black">Верификация пройдена</span>
					</div>
				<?php elseif (empty($passport->request_id) AND $passport->verify!=UserPassport::VERIFY_UNVERIFIED): ?>
                    <a class="checkValidation btn btn-medium btn-w js-modal-link" style="padding: 10px 20px;margin-bottom: 15px;">Пройти верификацию</a>
                    <!--<a href='#!' data-id-modal="verifyPopup" class="btn btn-medium btn-w js-modal-link" style="padding: 10px 20px;margin-bottom: 15px;">Пройти верификацию</a>-->
				<?php elseif ($passport->verify==UserPassport::VERIFY_WAIT): ?>
					<div class="dashboard-contacts__item">
						<span class="_black">Запрос на верификацию отправлен</span>
					</div>
				<?php elseif ($passport->verify==UserPassport::VERIFY_UNVERIFIED): ?>
					<div class="dashboard-contacts__item" style="display: inline-flex!important;">
						<span class="icon-close"></span>
						<span class="_black">Верификация не пройдена</span>
					</div>
                    <a class="checkValidation btn btn-medium btn-w js-modal-link" style="padding: 10px 20px;margin-bottom: 15px;">Пройти верификацию</a>
					<!--<a href='#!' data-id-modal="verifyPopup" class="btn btn-medium btn-w js-modal-link" style="padding: 10px 20px;margin-bottom: 15px;">Пройти повторно</a>-->
				<?php endif;?>
			</span>
		</h1>
	</div>
	<div class="col col-1">
		<?php
		$form = ActiveForm::begin([
			'options'                => ['enctype' => 'multipart/form-data'],
			'enableAjaxValidation'   => false,
			'enableClientValidation' => true,
			//'validateOnBlur' => true,
            'id' => 'profile-form'
		]);
        echo Html::activeHiddenInput($user, 'check');
        echo Html::activeHiddenInput($user, 'verify_save');
		echo $this->render('profile_update/' . $view, [
			'model' => $model,
			'user'  => $user,
			'form'  => $form,
            'readonly' => $readonly,
		]);
		?>
		<div class="title-row title-row--empty" id="passport">
			<div class="title-row__title">
				<p class="h2">Паспортные данные</p>
			</div>
		</div>
		<div class="contant-row">
			<style>
				.lk-form__row {
					margin-bottom: 10px;
				}
			</style>
			<?= $this->render('profile_update/personal_info_passport', [
				'form'     => $form,
				'passport' => $passport,
				'readonly' => $readonly,
			]) ?>
		</div>

		<div class="contant-row">
			<?= Html::button($model->isNewRecord ? 'Сохранить' : 'Обновить', ['class' => 'btn btn--next onValidates', 'onclick' => 'return CheckChangeName()']) ?>
            <?php //if(!$user->checkUser()): ?>
                <?php if (empty($passport->request_id)): ?>
                    <a class="checkValidation btn btn--next">Пройти верификацию</a>
                    <a style="display: none;" href='#!' data-id-modal="verifyPopup" class="verifyPopup btn btn--next js-modal-link">Пройти верификацию</a>
                <?php elseif ($passport->verify==0): ?>
                    <button disabled="disabled" class="verifyPopup btn btn--next">Запрос отправлен</button>
                <?php endif;?>
            <?php //endif;?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
	<div class="col col-2">
		<?php echo SideHelper::widget(); ?>
	</div>
</div>

<?php
$js =<<<JS
				jQuery('.checkValidation').click(function() {
				    form = jQuery('#profile-form');
				    jQuery.ajax({
                            url: "/user/validate",
                            type: "POST",
                            cache: true,
                            dataType: "json",
                            data: form.serialize(),
                            success: function(response) {
                                //$('.has-error').removeClass('has-error');
                                //$('.help-block-error').text('');
                                $('.has-error').removeClass('has-error');
                                $('.help-block-error').text('');
                                for(var k in response) {
                                    group = $('.field-'+k);
                                    group.addClass('has-error');
                                    group.find('.help-block-error').text(response[k]);
                                    group.find('input').focus();
                                }
                                
                                if(response.length==0){                                    
                                    $('.verifyPopup').click();
                                }else{
                                    $('.has-error').first().find('input').focus();
                                }
                                console.log(response);
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });                        
                    return false;
				});	
jQuery('.onValidates').click(function() {
				    form = jQuery('#profile-form');
				    jQuery.ajax({
                            url: "/user/validate",
                            type: "POST",
                            cache: true,
                            dataType: "json",
                            data: form.serialize(),
                            success: function(response) {
                                //$('.has-error').removeClass('has-error');
                                //$('.help-block-error').text('');
                                $('.has-error').removeClass('has-error');
                                $('.help-block-error').text('');
                                for(var k in response) {
                                    group = $('.field-'+k);
                                    group.addClass('has-error');
                                    group.find('.help-block-error').text(response[k]);
                                    group.find('input').focus();
                                }
                                
                                if(response.length==0){                                    
                                    form.submit();
                                }else{
                                    $('.has-error').first().find('input').focus();
                                    return false;
                                }
                                console.log(response);
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });                        
                    return false;
				});	
JS;
$this->registerJS($js);
?>
<script>
    function CheckChangeName() {
        $.post('/user/name-changed', $('#profile-form').serialize(), function (response) {
            if (response.changed){
                $('#check-fio-modal').arcticmodal();
            } else
                $('#user-check').val('');//saveProfile('');
        }, 'json');
        return false;
    }
    function saveProfile(check) {
        $('#user-check').val(check);
        $('#profile-form').submit();
    }
</script>