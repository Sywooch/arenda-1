<?php
/**
 * Created by PhpStorm.
 * User: Ulugbek
 * Date: 02.03.2017
 * Time: 13:06
 */
use app\components\extend\Html;

$context = $this->context;
$cover = $context->model->getImages()->where(['cover'=>1])->one();
$image = '';
if($cover){
    $image = 'src="'.$cover->file->path.$cover->file->id.'.'.$cover->file->extension.'"';
}
//$headerImageUrl = $context->model->cover->file->getImageUrl(['width' => 1226, 'height' => 400]);
?>

<div class="arg_i_add js-imgUpload--imglist">
    <div class="js-imgUpload--bg arg_i_add--bg" <?php if($cover){ echo 'style="background-color: rgb(255, 255, 255); z-index: 2;"';}?>>
        <img class="js-imgUpload--bg-img" alt="" <?=$image ?>>
    </div>
    <div class="arg_i_add arg_i_add-1">
        <p>
        <div class="icon icon-home"></div>
        </p>
        <p>
            <label for="ads-images-cover" class="btn btn-y h-b-14">Загрузить обложку</label>
            <?php
            $name = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getInputName($context->model, $context->attribute) : $context->name;
            $value = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getAttributeValue($context->model, $context->attribute) : $context->value;
            $context->options['id']='ads-images-cover';
            echo Html::fileInput($name, $value, $context->options);
            ?>
        </p>
        <div class="arg_i_add--in" style="z-index: 3;">
            <?php if(!$cover){ ?>
                <a class="del" href="javascript:void(0);"></a>
                <a class="res" href="javascript:void(0);"></a>
                <a class="res--on" href="javascript:void(0);"></a>
            <?php }else{ ?>
                <a class="del" onclick="deleteCoverAdImage($(this));" data-delete-container=".js-imgUpload--bg" data-id="<?php echo $context->model->id;?>" data-imgId="<?php echo $cover->id;?>" data-url="/ads/delete-image?id=<?php echo $context->model->id;?>&imgId=<?php echo $cover->id;?>" href="javascript:void(0);"></a>
                <a class="res" style="display: none;" href="javascript:void(0);"></a>
                <a class="res--on" style="display: none;" href="javascript:void(0);"></a>
            <?php } ?>
        </div>
        <p class="h-r-13">или перетащите её сюда</p>
        <div class="drag-loader--msg"></div>
    </div>
</div>
