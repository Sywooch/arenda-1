<?php
/**
 * Created by PhpStorm.
 * User: Ulugbek
 * Date: 02.03.2017
 * Time: 13:06
 */
use app\components\extend\Html;

$context = $this->context;
//print_r($context); die;
$cover = $context->model->getScanUrl();//$context->model->getImages()->where(['cover'=>1])->one();
$image = '';
if(!empty($context->model->scan_passport)){
    $image = 'src="'.$cover = $context->model->getScanUrl().'"';
}
?>

<div class="arg_i_add js-imgUpload--imglist">

    <div class="arg_i_add arg_i_add-1" style="padding: 0!important;">
        <div class="js-imgUpload--bg arg_i_add--bg" style="position: relative; <?php if(!empty($context->model->scan_passport)){ echo ' z-index: 2;';}?>" >
            <img class="js-imgUpload--bg-img" style="margin-bottom: 0;" alt="" <?=$image ?>>
        </div>
        <p class="upbutton" style="<?php if(!empty($context->model->scan_passport)){ echo 'display: none;';}?>">
            <label for="userpassport-scan_passport" class="btn btn-y h-b-14 btn--next" style="cursor: default!important;">Загрузить скан паспорт</label>
            <?php
            $name = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getInputName($context->model, $context->attribute) : $context->name;
            $value = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getAttributeValue($context->model, $context->attribute) : $context->value;
            $context->options['id']='ads-images-cover';
            echo Html::fileInput($name, $value, $context->options);
            ?>
        </p>
        <?php //if($context->model->verify!=1){ ?>
        <div class="arg_i_add--in" style="z-index: 3;">
            <?php if(!$cover){ ?>
                <a class="del" href="javascript:void(0);"></a>
            <?php }else{ ?>
                <a class="del" onclick="deleteScanPassportImage($(this));" data-delete-container=".js-imgUpload--bg" data-id="<?php //echo $context->id;?>" data-imgId="<?php echo $context->model->scan_passport;?>" data-url="/user/delete-image?imgId=<?php echo $context->model->scan_passport;?>" href="javascript:void(0);"></a>
            <?php } ?>
        </div>
        <?php //} ?>
        <!--<p class="h-r-13">или перетащите её сюда</p>
        <div class="drag-loader--msg"></div>-->
    </div>
</div>
