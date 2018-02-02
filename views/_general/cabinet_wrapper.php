<?php
use app\components\widgets\SideHelper;
use yii\widgets\ActiveForm;

?>
<div class="wrapper-lk">
	<section class="lk-temp lk-temp-apps cf">
		<div class="col col-1 col-1_no-bg">

			<!-- .application__top -->
			<div class="lk-temp__top lk-temp__top_apps" style="padding-top: 0px!important;">
                <div class="lk-profile-ts">
                    <h1 class="lk-profile-t-t__title"><?= (isset($pageHeader)) ? $pageHeader : 'Страница' ?></h1>
                    <p class="lk-profile-t__sub"></p>
                </div>
				<div class="lk-temp__left">
					<?php if (!isset($pageHeaderNoSearchInput) || (isset($pageHeaderNoSearchInput) && $pageHeaderNoSearchInput == false)): ?>
						<?php
						$model = $data['searchModel'];
						$form = ActiveForm::begin([
							'method' => 'get',
							'action' => '?'
						]) ?>
						<div class="pos-rel">
							<?= $form->field($model, 'street')->textInput(['class'=>'lk-temp__input_search','placeholder'=>'Поиск по адресу'])->label(false) ?>
							<input type="submit" class="search-submit-btn" value="">
						</div>
						<?php ActiveForm::end() ?>
					<?php endif; ?>
				</div>
				<?php
				if (isset($pageHeaderAddonView) && $pageHeaderAddonView) {
					echo $this->render($pageHeaderAddonView, (isset($pageHeaderAddonViewData)) ? $pageHeaderAddonViewData : []);
				}
				?>
			</div>

			<?php
			if (isset($view)) {
				echo $this->render($view, (isset($data)) ? $data : []);
			}
			?>

		</div>
		<div class="col col-2 col-i">
			<?= SideHelper::widget(); ?>
		</div>
	</section>
</div>

