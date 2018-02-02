<section class="registr-sect">
	<div class="wrapper">

		<?=
		$this->render('//site/sign_up/_form', [
			'model' => Yii::$app->controller->signupForm,
		]);
		?>

	</div>
</section>
