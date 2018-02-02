<?php
use app\components\extend\Html;
use app\models\Ads;

?>

<div class="lk-form__row">
    <div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'house_floors'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
            <?= $form->field($model, 'house_floors')->textInput([
                'class' => 'input--main lk-form--input-sm js-num-input-validate',
            ])->error(false)->hint(false);
            ?>
            <?= Html::error($model, 'house_floors', ['tag' => 'p', 'class' => 'help-block help-block-error']) ?>
	</div>
</div>
<div class="lk-form__row">
    <div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'location_floor'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
            <?= $form->field($model, 'location_floor')->textInput([
                'class' => 'input--main lk-form--input-sm js-num-input-validate',
            ])->error(false)->hint(false);
            ?>
            <?= Html::error($model, 'location_floor', ['tag' => 'p', 'class' => 'help-block help-block-error']) ?>
	</div>
</div>
<div class="lk-form__row">
    <div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'building_type'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
        <div class="Check_fam h4 Check_fam--col Check_fam--cir">
            <?= Html::error($model, 'building_type', ['tag' => 'p', 'class' => 'help-block help-block-error']) ?>
            <?php
            $buildingTypes          = Ads::getBuildingTypeLabels();
            $buildingTypesChunkSize = ceil(count($buildingTypes) / 2);
            $buildingChunks         = array_chunk($buildingTypes, $buildingTypesChunkSize, true);
            ?>
            <?php foreach ($buildingChunks as $chunkIndex => $buildingChunk): ?>
                <ol>
                    <?= $form->field($model, 'building_type')->error(false)->radioList($buildingChunk, [
                        'unselect' => null,
                        'item'     => function ($index, $label, $name, $checked, $value) use ($chunkIndex) {

                            $contents = [];

                            $contents[] = Html::beginTag('li');

                            $id         = $name . '_' . $chunkIndex . '_' . $index;
    
                            if ($chunkIndex === 0 && $index === 0) {
                                $checked = 'checked';
                            }
                            
                            $contents[] = Html::radio($name, $checked, [
                                'id'    => $id,
                                'value' => $value,
                            ]);
                            $contents[] = Html::label(Html::tag('i', '', ['class' => 'Check_fam__view']) . $label, $id);

                            $contents[] = Html::endTag('li');

                            return implode("\n", $contents);
                        },
                    ]) ?>
                </ol>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="lk-form__row">
    <div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'elevator_passenger'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
        <div class="Half_btn h4 Half_btn--big">
            <div class="Half_btn_con">
                <label for="h_ce0" class="Half_btn__item<?= ($model->elevator_passenger == 0) ? ' active' : ''; ?>">
                    Нет
                </label>
                <label for="h_ce1" class="Half_btn__item<?= ($model->elevator_passenger == 1) ? ' active' : ''; ?>">
                    1
                </label>
                <label for="h_ce2" class="Half_btn__item<?= ($model->elevator_passenger == 2) ? ' active' : ''; ?>">
                    2
                </label>
                <label for="h_ce3" class="Half_btn__item<?= ($model->elevator_passenger == 3) ? ' active' : ''; ?>">
                    3
                </label>
                <label for="h_ce4" class="Half_btn__item<?= ($model->elevator_passenger == 4) ? ' active' : ''; ?>">
                    4
                </label>
            </div>
            <i></i>
            <div class="Half_btn__hide">
				<?php echo Html::activeRadio($model, 'elevator_passenger', ['id' => 'h_ce0', 'value' => 0, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'elevator_passenger', ['id' => 'h_ce1', 'value' => 1, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'elevator_passenger', ['id' => 'h_ce2', 'value' => 2, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'elevator_passenger', ['id' => 'h_ce3', 'value' => 3, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'elevator_passenger', ['id' => 'h_ce4', 'value' => 4, 'uncheck' => null]); ?>
			</div>
        </div>
    </div>
</div>
<div class="lk-form__row">
    <div class="lk-form__col-l">
        <p class="lk-form--p-c">
            <?= Html::activeLabel($model, 'elevator_service'); ?>
        </p>
    </div>
    <div class="lk-form__col-r">
        <div class="Half_btn h4 Half_btn--big">
            <div class="Half_btn_con">
                <label for="h_cf0" class="Half_btn__item<?= ($model->elevator_passenger == 0) ? ' active' : ''; ?>">
                    Нет
                </label>
                <label for="h_cf1" class="Half_btn__item<?= ($model->elevator_passenger == 1) ? ' active' : ''; ?>">
                    1
                </label>
                <label for="h_cf2" class="Half_btn__item<?= ($model->elevator_passenger == 2) ? ' active' : ''; ?>">
                    2
                </label>
                <label for="h_cf3" class="Half_btn__item<?= ($model->elevator_passenger == 3) ? ' active' : ''; ?>">
                    3
                </label>
                <label for="h_cf4" class="Half_btn__item<?= ($model->elevator_passenger == 4) ? ' active' : ''; ?>">
                    4
                </label>
            </div>
            <i></i>
            <div class="Half_btn__hide">
				<?php echo Html::activeRadio($model, 'elevator_service', ['id' => 'h_cf0', 'value' => 0, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'elevator_service', ['id' => 'h_cf1', 'value' => 1, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'elevator_service', ['id' => 'h_cf2', 'value' => 2, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'elevator_service', ['id' => 'h_cf3', 'value' => 3, 'uncheck' => null]); ?>
				<?php echo Html::activeRadio($model, 'elevator_service', ['id' => 'h_cf4', 'value' => 4, 'uncheck' => null]); ?>
			</div>
        </div>
    </div>
</div>
