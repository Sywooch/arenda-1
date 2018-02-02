<?php

use app\components\extend\Html;
use yii\web\View;
use app\models\AttributesMap;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */
?>


<?php
$content = '';
$childAttributes = AttributesMap::find()->innerJoinWith(['adValues' => function($query) use ($model) {
                return $query->andWhere([
                            'ad_id' => $model->primaryKey
                ]);
            }])->where([
                    'purpose' => AttributesMap::PURPOSE_AD,
                    'show_to_customers' => 1,
                    'parent' => $attr->primaryKey,
                ])->orderBy(['position' => SORT_ASC])->all();
        if ($childAttributes) {
            foreach ($childAttributes as $cattr) {
                /* @var $cattr AttributesMap */
                $content.= $this->render('_item', [
                    'model' => $cattr,
                    'ad' => $model
                ]);
                $content.=$this->render('_children', [
                    'attr' => $cattr,
                    'model' => $model
                ]);
            }
        }

        echo Html::tag('div', $content,[
            'style'=>'margin-left:20px;'
        ]);
        