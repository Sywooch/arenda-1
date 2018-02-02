<?php

namespace app\components\widgets\attributes\attributes_map;

use yii;
use yii\base\Widget;
use app\models\AttributesMap;

class AttributesMapWidget extends Widget
{
    const TYPE_AD_ATTRIBUTES = 'ad_attributes';

    public $view;
    public $type;
    public $params = [];

    public function run()
    {
        if (!$this->view) {
            $this->view = $this->type;
        }
        $this->params = array_merge([
            'map' => $this->getMapByType()
                ], $this->params
        );
        $this->params['params'] = $this->params;
        AttributesMapWidgetAssets::register(yii::$app->controller->view);
        return $this->render('@app/components/widgets/attributes/attributes_map/views/' . $this->view, $this->params);
    }

    /**
     * get attributes map
     * @return mixed null | AttributesMap
     */
    public function getMapByType()
    {
        switch ($this->type) {
            case self::TYPE_AD_ATTRIBUTES:
                return AttributesMap::find()->where(['purpose' => AttributesMap::PURPOSE_AD, 'parent' => 0])->orderBy(['position' => SORT_ASC])->all();
            default :
                return null;
        }
    }

}