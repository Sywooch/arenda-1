<?php

use app\components\extend\Html;
use yii\web\View;
use app\models\AttributesMap;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$echoAttributes = '';
$allContent = '';
$attributes = AttributesMap::find()->innerJoinWith(['adValues' => function($query) use ($model) {
                return $query->andWhere([
                            'ad_id' => $model->primaryKey
                ]);
            }])->where([
                    'purpose' => AttributesMap::PURPOSE_AD,
                    'show_to_customers' => 1,
                    'parent' => 0,
                ])->orderBy(['position' => SORT_ASC])->all();
        if ($attributes) {
            foreach ($attributes as $attr) {
                $echoChildAttributes = '';
                /* @var $attr AttributesMap */
                $echoAttributes = $this->render('_ad_view_attributes/_item', [
                    'model' => $attr,
                    'ad' => $model
                ]);
                $echoChildAttributes.= $this->render('_ad_view_attributes/_children', [
                    'attr' => $attr,
                    'model' => $model
                ]);
                $content = ($attr->input_type == AttributesMap::INPUT_TYPE_HIDDEN && trim($echoChildAttributes) == '') ? '' : $echoAttributes . $echoChildAttributes;
                $allContent.= $content;
            }
        }

        echo $allContent;
        