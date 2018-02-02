<?php
use app\components\extend\Html;
use yii\bootstrap\ActiveForm;
use app\models\Ads;
use app\components\widgets\CustomDropdown\CustomDropdown;
use app\components\widgets\AirDatepicker\AirDatepicker;
use yii\helpers\ArrayHelper;
use limion\jqueryfileupload\JQueryFileUpload;

?>
	<style>.blueimp-gallery{display: none;}</style>
<?php
echo JQueryFileUpload::widget([
	//'id' => 'cover-image-input',
	'model'         => $model,
	'attribute'     => 'images',
	'url'           => ['image-upload', 'ad_id' => $model->id, 'cover' => true], // your route for saving images,
	'appearance'    => 'plus', // available values: 'ui','plus' or 'basic'
	'mainView'      => '@app/views/ads/form/cover_upload',
	'options'       => ['accept' => 'image/*'],
	'clientOptions' => [
		'maxFileSize'      => 2000000,
		'dataType'         => 'json',
		'acceptFileTypes'  => new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
		'autoUpload'       => true,
		'previewMaxWidth'  => '400',
		'previewMaxHeight' => '400',
	],
	'clientEvents'  => [
		'add'  => "function (e, data) {
				    $('.__submit').prop('disabled', true);
				}",
		'done' => "function (e, data) { 					
 				    $.each(data.result.files, function (index, file) {
 				       var canvas = data.files[0].preview;
                       var dataURL = canvas.toDataURL();
                       var img = $('<img/>');
                       img.attr('src', file.thumbnailUrl);
                       $('.upload-grid__item.upload-grid__item--big .js-imgUpload--imglist').html('').append(img);                                    
		            });
		            $('.__submit').prop('disabled', false);
			    }",
	],
]);

$this->registerJs(<<<JS
	$('.js-imgUpload').imageUpload("/ads/image-upload?ad_id=$model->id");
	//$('.upload-grid__item').imageUpload("/ads/image-upload?ad_id=$model->id", {uploadGrid: true});
JS
);

