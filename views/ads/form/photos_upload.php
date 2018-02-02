<?php
use app\components\extend\Html;

$context = $this->context;
?>
<div class="arg_i_add--row js-imgUpload--imglist js-imgUpload--imglist-cont">
	<?php
	$images = $context->model->getImages()->where(['cover'=>0])->all();

	if ($images != null):
		foreach ($images as $image):?>
			<div class="arg_i_add arg_i_add--s delcont_<?php echo $image->id;?>">
				<div class="JsImg" data-img="<?php echo $image->file->path; echo $image->file->id; echo '.'.$image->file->extension;?>" style="background-image: url('<?php echo $image->file->path; echo $image->file->id; echo '.'.$image->file->extension;?>');">
					<div class="arg_i_add--in">
						<a class="del" onclick="deleteAdImage($(this))" data-delete-container=".delcont_<?php echo $image->id;?>" data-id="<?php echo $context->model->id;?>" data-imgId="<?php echo $image->id;?>" data-url="/ads/delete-image?id=<?php echo $context->model->id;?>&imgId=<?php echo $image->id;?>" href="javascript:void(0);"></a>
						<!--<a href="#">Сделать обложкой</a>-->
					</div>
				</div>
				<!--<input type="text" placeholder="Добавить подпись">-->
			</div>
		<?php
        endforeach;
        endif;
		?>
</div>
<label for="ads-images" class="arg_i_add arg_i_add--s arg_i_add--new js-imgUpload--imglist">
	<p class="h-m-30">+</p>
	<p class="h-m-15">Добавить еще</p>
	<?php
	$name = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getInputName($context->model, $context->attribute) : $context->name;
	$value = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getAttributeValue($context->model, $context->attribute) : $context->value;
	echo Html::fileInput($name, $value, $context->options);
	?>
</label>