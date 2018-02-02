<?php
use app\components\extend\Url;
use app\components\extend\Html;
?>
<div class="lk-temp__buttonss">
	<?=
	Html::a('Создать', '#!', [
		'class' => 'btn btn-normal btn-normal--w-160 btn-y js-modal-link-ajax __create_estate',
		'title' => 'Создать',
		'data'  => [
			'href' => Url::to(['create']),
			'pjax' => 0,
		],
	]);
	?>
	<!--<a href="<?/*= Url::to(['create']) */?>" class="btn btn-normal btn-normal--w-160 btn-y js-modal-link" data-id-modal="createObject">
		Создать
	</a>-->
</div>