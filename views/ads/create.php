<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Ads */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_steps', [
	'model' => $model,
	'step'  => $step,
]); ?>


<?php
$form = ActiveForm::begin([
	'id'                     => 'ad-create-form',
	'enableClientValidation' => false,
	'enableAjaxValidation'   => false,
	'options'                => [
		'class' => 'lk-form lk-form--row-3-7 lk-form--row-p-20  lk-form--step-1',
	],
]);
?>

<?=
$this->render('form/' . $stepView, [
	'model' => $model,
	'form'  => $form,
])
?>
<?php if(Yii::$app->request->isPjax):?>
	<script>
		$(document).ready(function () {
			dropDown();
			half_btn();
			var $select = $('.js-selector');

			if(!$select.length) return;

			$select.customSelector({});
		})
	</script>
	<?php endif; ?>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
   function saveConfirmation () {
		if (confirm('Сохранить информацию?')) {   
		    $.ajax({
			  url: window.location.href+'&forceSave=1',
			  method: 'POST',
			  async : false,
			  data: $('#ad-create-form').serialize(),			 
			});
	    }
   }     
  $(window).bind('beforeunload', function(){
      setTimeout( saveConfirmation, 0 );
      return;
  });
  
  $('#ad-create-form').on('submit', function(){
      $(window).unbind('beforeunload');
  });
JS;

$this->registerJS($js);
