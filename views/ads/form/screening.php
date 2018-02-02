<?php
use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\Ads;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;
use yii\helpers\ArrayHelper;

?>
<label for="cam21" class="block_rew block_rew--1">
	<span class="icon icon-calque"></span>
	<div class="Check_fam h4 Check_fam--big Check_fam--sq">
		<ol>
			<li class="topCheck">
				<?= $form->field($model, 'check_credit_reports', [
					'options' => [
						'tag' => null,
					],
				])->checkbox([
					'template'  => '{input}',
					'unselect'   => null,
					'id'        => 'cam21',
					'class'     => 'js-checkbox',
					'data-cost' => 199,
					'data-payed' => 0,
				])->label(false)->hint(false); ?>
				<i class="Check_fam__view"></i>
				<p class="h-m-15 lab">Требовать отчеты<br>о кредитных операциях</p>
			</li>
		</ol>
	</div>
	<p class="h4 h-bg-gray">
		Всем кандидатам будет предложено представить отчет о кредитных операциях. Включает в себя кредитный
		счет, подробную историю платежей и обзор задолженностей.
	</p>
	<a href="#">Образец<i class="icon icon-arr_r_up"></i></a>
</label>
<label for="cam22" class="block_rew block_rew--2">
	<span class="icon icon-loup"></span>
	<div class="Check_fam h4 Check_fam--big Check_fam--sq">
		<ol>
			<li class="topCheck">
				<?= $form->field($model, 'check_biographical_information', [
					'options' => [
						'tag' => null,
					],
				])->checkbox([
					'template'  => '{input}',
					'unselect'   => null,
					'id'        => 'cam22',
					'class'     => 'js-checkbox',
					'data-cost' => 199,
					'data-payed' => 0,
				])->label(false)->hint(false); ?>
				<i class="Check_fam__view"></i>
				<p class="h-m-15 lab">Проверять<br>биографические данные</p>
			</li>
		</ol>
	</div>
	<p class="h4 h-bg-gray">
		Всем кандидатам будет предложено запустить проверку их биографических данных. Включает в себя поиск и
		подверждение информации о жильце, проверка судимостей.
	</p>
	<a href="#">Образец<i class="icon icon-arr_r_up"></i></a>
</label>
