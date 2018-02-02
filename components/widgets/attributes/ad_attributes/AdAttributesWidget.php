<?php

namespace app\components\widgets\attributes\ad_attributes;

use yii;
use yii\base\Widget;
use app\models\AttributesMap;

class AdAttributesWidget extends Widget
{
    public $view = 'ad_view_attributes';
    public $header = '<h3>Удобства</h3>';
    public $params = [];

    public function run()
    {
        $attributes = $this->render('@app/components/widgets/attributes/ad_attributes/views/' . $this->view, $this->params);
        return (trim($attributes) != '' ? $this->header . $attributes : '');
    }

}