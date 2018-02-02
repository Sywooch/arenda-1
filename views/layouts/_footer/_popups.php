<div style="display: none;">
	<div class="box-modal modal" id="_modal-message">
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title modal--ok" id="_modal-message-text">Объект успешно изменен</h2>
		</div>
	</div>
</div>

<?php if(Yii::$app->user->isGuest): ?>
<!-- login -->
<div style="display: none;">
	<div class="box-modal modal" id='login'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr2">
			<h2 class="modal__title h-mrg-t-10">Войти на сайт</h2>
			<div class="modal__body">
				<?=
				$this->render('//site/login/_form', [
					'model' => new app\models\forms\LoginForm(),
				]);
				?>
			</div>
		</div>
	</div>
</div>
<!-- end login -->

<!-- registration -->
<div style="display: none;">
	<div class="box-modal modal modal-reg" id='registration'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<section class="registr-sect">
			<div class="wrapper">
				<?=
				$this->render('//site/sign_up/_form', [
					'model' => Yii::$app->controller->signupForm,
				]);
				?>
			</div>
		</section>
	</div>
</div>
<!-- end registration -->

<!-- password recovery -->
<div style="display: none;">
	<div class="box-modal modal" id="password-recovery">
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr2">
			<h2 class="modal__title h-mrg-t-10">Восстановить пароль</h2>
			<div class="modal__body">
				<?=
				$this->render('//site/requestPasswordResetToken', [
					'model' => Yii::$app->controller->passwordResetRequestForm,
				]);
				?>
			</div>
		</div>
	</div>
</div>
<!-- end password recovery -->
<?php endif; ?>

<!-- resultAdd -->
<div style="display: none;">
	<div class="box-modal modal" id='resultAdd'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title modal--ok">Объект успешно добавлен</h2>
		</div>
	</div>
</div>
<!-- end resultAdd -->

<!-- resultEdit -->
<div style="display: none;">
	<div class="box-modal modal" id='resultEdit'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title modal--ok">Объект успешно изменен</h2>
		</div>
	</div>
</div>
<!-- end resultEdit -->

<!-- delete -->
<div style="display: none;">
	<div class="box-modal modal" id='deletePopup'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title modal--delete">Вы действительно хотите удалить выбранный пункт?</h2>
			<form action="#" class="madal-form modal-delete">
				<a href="#!" class="btn btn-y arcticmodal-close">Да</a>
				<div class="btn btn-pur arcticmodal-close">Нет</div>
			</form>
		</div>
	</div>
</div>
<!-- end delete -->

<!-- verify -->
<div style="display: none;">
	<div class="box-modal modal" id='canVerifyPopup'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title modal--delete">Для подписания договора вы должны пройти верификацию</h2>
			<form action="#" class="madal-form modal-delete">
				<a href="/user/profile-update" class="btn btn-y">Пройти</a>
				<div class="btn btn-pur arcticmodal-close">Нет</div>
			</form>
		</div>
	</div>
</div>
<!-- end verify -->

<div style="display: none;">
    <div id="check-modal" class="box-modal modal">
        <div class="modal__close box-modal_close arcticmodal-close"></div>
        <div class="modal__wr">
            <h2 class="modal__title modal--delete">Хотите запустить проверку повторно?</h2>
            <form id="item-check-form" action="#" class="madal-form modal-delete">
                <button type="submit" onclick="saveAddress(true);return false;" class="btn btn-y">Да</button>
                <div class="btn btn-pur arcticmodal-close" onclick="saveAddress();">Нет</div>
            </form>
        </div>
    </div>
</div>

<div style="display: none;">
    <div id="check-fio-modal" class="box-modal modal">
        <div class="modal__close box-modal_close arcticmodal-close"></div>
        <div class="modal__wr">
            <h2 class="modal__title modal--delete">Хотите запустить проверку всех объектов повторно?</h2>
            <form id="item-check-fio-form" action="#" class="madal-form modal-delete">
                <button type="submit" onclick="saveProfile(true);return false;" class="btn btn-y">Да</button>
                <div class="btn btn-pur arcticmodal-close" onclick="saveProfile('');">Нет</div>
            </form>
        </div>
    </div>
</div>

<!-- popups end -->


<?php
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
	Yii::$app->view->registerJs(new \yii\web\JsExpression("\$(function(){mes('$message','$key'); })"), \yii\web\View::POS_READY);
}
?>