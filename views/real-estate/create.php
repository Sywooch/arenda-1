<?php

use app\components\extend\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RealEstate */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Недвижимость', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-modal modal">
	<div class="modal__close box-modal_close arcticmodal-close"></div>
	<div class="modal__wr">
		<?= $this->render('_form', [
			'model' => $model,
            'estateUser' => $estateUser,
		]) ?>
	</div>
</div>
