<?php
use yii\helpers\Html;

$context = $this->context;
?>
<div class="wpapper-con" style="margin: -13px 0;">
	<div class="upload-grid__item upload-grid__item--big" style="width: 100%; margin: 10px 0;">
		<div class="arg_i_add js-imgUpload--imglist">
			<?php
			if ($context->model->cover_image != '') {
				echo $context->model->renderCover(['width' => 497, 'height' => 236]);
			}
			?>
		</div>
		<div class="arg_i_add arg_i_add-1">
			<p>
			<div class="icon icon-plus"></div>
			</p>
			<p>
				<?php
				$name = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getInputName($context->model, $context->attribute) : $context->name;
				$value = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getAttributeValue($context->model, $context->attribute) : $context->value;
				echo Html::fileInput($name, $value, $context->options);
				?>
			</p>
			<p class="h-r-13">Добавить фото</p>
			<div class="drag-loader--msg"></div>
		</div>
	</div>
</div>