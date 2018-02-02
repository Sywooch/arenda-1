<?php

use app\components\extend\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Новый договор';
$this->params['breadcrumbs'][] = ['label' => 'Договоры аренды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_steps', [
	'model' => $model,
	'step'  => $step,
]); ?>


<?php
$form = ActiveForm::begin([
	'id'                     => 'lease-contract-form',
	'enableClientValidation' => false,
	'enableAjaxValidation'   => false,
	'options'                => [
		'class' => 'lk-form lk-form--row-3-7 lk-form--row-p-20  lk-form--step-1',
	],
]);
?>

<?=
$this->render('form/' . $stepView, [
	'model'        => $model,
	'payment'      => $payment,
	'form'         => $form,
	'participants' => $participants,
])
?>
<?php
if(Yii::$app->request->isPjax){
	?><script>
		(function(){
			var $select = $('.js-selector');

			if(!$select.length) return;

			$select.customSelector({});
		})(jQuery);
	</script>
	<?php
}
?>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
   function saveConfirmation () {
		if (confirm('Сохранить информацию?')) {   
		    $.ajax({
			  url: window.location.href+'&forceSave=1',
			  method: 'POST',
			  async : false,
			  data: $('#lease-contract-form').serialize(),			 
			});
	    }
   }     
  $(window).bind('beforeunload', function(){
      setTimeout( saveConfirmation, 0 );
      return ;
  });
  
  $('#lease-contract-form').on('submit', function(){
      $(window).unbind('beforeunload');
  });
JS;

$this->registerJS($js);
?>
