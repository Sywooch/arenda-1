<?php

use app\components\extend\Html;
use app\components\widgets\AirDatepicker\AirDatepicker;

?>
<div class="title-row title-row--empty">
	<div class="title-row__title">
		<p class="h2">Общая информация</p>
	</div>
</div>
<div class="contant-row">
	<div class="lk-set-form--inf lk-set-form lk-form lk-form--row-3-7 lk-form--row-p-20 no--p no--m">
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'last_name') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'last_name') ?></p>
				</div>
				<?= $form->field($user, 'last_name')->textInput(['class' => 'input--main lk-form--input-md','readonly' => $readonly])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'first_name') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'first_name') ?></p>
				</div>
				<?= $form->field($user, 'first_name')->textInput(['class' => 'input--main lk-form--input-md','readonly' => $readonly])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'middle_name') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'middle_name') ?></p>
				</div>
				<?= $form->field($user, 'middle_name')->textInput(['class' => 'input--main lk-form--input-md','readonly' => $readonly])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'email') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'email') ?></p>
				</div>
				<?= $form->field($user, 'email')->textInput(['class' => 'input--main lk-form--input-md'])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'phone') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'phone') ?></p>
				</div>
				<?= $form->field($user, 'phone')->textInput(['class' => 'input--main lk-form--input-md phoneMask'])->label(false); ?>
			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p required"><?= Html::activeLabel($user, 'date_of_birth') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p required"><?= Html::activeLabel($user, 'date_of_birth') ?></p>
				</div>
                <?php if($readonly):
                    $user->date_of_birth = $user->getDate('date_of_birth', 'd.m.Y');
                    ?>
                    <?= $form->field($user, 'date_of_birth')->textInput(['class' => 'input--main lk-form--input-md','readonly' => $readonly])->label(false); ?>
                <?php else: ?>
                    <?= $form->field($user, 'date_of_birth')->widget(AirDatepicker::classname(), [
                        'options' => [
                            'class'       =>
                                $readonly==false ? 'input air-datepicker':'input',
                            'placeholder' => 'Выберете дату...',
                            'value'       => $user->getDate('date_of_birth', 'd.m.Y'),
                            'readonly' => $readonly,
                        ],
                    ]);
                    ?>
                <?php endif; ?>

			</div>
		</div>
		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p"><?= Html::activeLabel($model, 'photo') ?></p>
			</div>
			<div class="lk-form__col-r lk-edit__img lk-edit--w js-imgUpload">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p"><?= Html::activeLabel($model, 'photo') ?></p>
				</div>
				<div class="js-imgUpload--imglist user_avatar">
					<?= $user->renderAvatar(['width' => 165, 'height' => 165]); ?>
				</div>
				<div class=""></div>
				<div class="lk-edit__imgBtn">
					<label for="lk-img" class="btn btn-lk-edit">Загрузить фото</label>
					<?= Html::activeFileInput($model, 'photo',['id'=>'userinfo-photo']) ?>
				</div>
			</div>
		</div>

		<div class="lk-form__row">
			<div class="lk-form__col-l">
				<p class="lk-set-p"><?= Html::activeLabel($model, 'about') ?></p>
			</div>
			<div class="lk-form__col-r">
				<div class="lk-form__hidden-subt">
					<p class="lk-set-p"><?= Html::activeLabel($model, 'about') ?></p>
				</div>
				<?= $form->field($model, 'about')->textarea(['class' => 'input--main textarea-1 lk-edit--w', 'rows' => 7])->label(false); ?>
			</div>
		</div>

	</div>
</div>
<?php
$js =<<<JS
				$('#userinfo-photo').on('change', function(){
					$('#w0').submit();
				});
                $('#userinfo-photo').on('change', function(){
					$('#profile-form').submit();
				});
JS;
$this->registerJS($js);
?>