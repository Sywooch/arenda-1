<?php

namespace app\models;

use yii;

class AdPublication extends \app\components\extend\ActiveRecord
{
    public static function tableName()
    {
        return '{{%ads_publications}}';
    }

    public function getAd()
    {
        return $this->hasOne(Ads::className(), ['id' => 'ad_id']);
    }
    
    public function getBoard()
    {
        return $this->hasOne(AdBoard::className(), ['id' => 'board_id']);
    }
}
