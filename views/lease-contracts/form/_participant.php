<?php
use app\components\extend\Html;

$i = 0;
?>

<?php foreach ($participants as $index => $participant): ?>
	<?php $i++; ?>
	<div class="lk-form__member js-member-contain js-member-duplicate-fields">
		<div class="lk-form__wr lk-form__wr--no-p-h">
			<div class="lk-form__title lk-form__title--p-sm">
				<p class="js-member-add--title">Участник <span><?= $i ?></span></p>
			</div>
		</div>
		<div class="separator-l separator-hide"></div>
		<div class="lk-form__wr lk-form__wr--p-2-3">

			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?= Html::activeLabel($participant, 'first_name'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-form--p-c"><?= Html::activeLabel($participant, 'first_name'); ?></p>
					</div>
					<?= $form->field($participant, "[$index]first_name")->textInput([
						'class' => 'input--main lk-form--input-md',
					])->label(false);
					?>
				</div>
			</div>
			<div class="lk-form__row">
				<div class="lk-form__col-l">
					<p class="lk-form--p-c"><?= Html::activeLabel($participant, 'email'); ?></p>
				</div>
				<div class="lk-form__col-r">
					<div class="lk-form__hidden-subt">
						<p class="lk-form--p-c"><?= Html::activeLabel($participant, 'email'); ?></p>
					</div>
					<?= $form->field($participant, "[$index]email")->textInput([
						'class' => 'input--main lk-form--input-md',
					])->label(false);
					?>
				</div>
			</div>
		</div>
		<?php if ($index > 0): ?>
		<div class="lk-form__row">
			<div class="lk-form__col-l"></div>
			<div class="lk-form__col-r">
				<div class="lk-form--inline">
					<div class="btn btn-lk-edit" onclick="Contract.Participant.deleteDuplicateFields($(this))">Убрать</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
<?php endforeach; ?>