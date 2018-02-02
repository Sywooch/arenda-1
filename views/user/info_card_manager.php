<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\components\extend\FileInput;
use app\components\helpers\CommonHelper;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $model app\models\UserInfo */
/* @var $model app\models\behaviors\common\SaveFilesBehavior */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="title-row title-row--empty">
	<div class="title-row__title">
		<p class="h2">Активные объявления</p>
	</div>
</div>
<div class="contant-row-2">
	<?=
	ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView'     => 'info_card_manager/_item',
		'summary'      => '',
	])
	?>
</div>