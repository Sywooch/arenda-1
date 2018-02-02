<?php

namespace app\modules\admin\components\widgets\attributes\attributes_map_manager;

use yii;
use yii\base\Widget;
use app\models\AttributesMap;
use yii\data\ActiveDataProvider;

class AttributesMapManagerWidget extends Widget
{
    public $view = 'index';
    public $type;
    public $params = [];

    public function run()
    {

        $query = AttributesMap::find();
        $query->where([
            'purpose' => AttributesMap::PURPOSE_AD,
            'parent' => 0
        ]);
        $this->params = array_merge([
            'dataProvider' => new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => ['id' => SORT_ASC]
                ]
                    ])
                ], $this->params
        );

        AttributesMapManagerWidgetAssets::register(yii::$app->controller->view);
        return $this->render('@app/modules/admin/components/widgets/attributes/attributes_map_manager/views/' . $this->view, $this->params);
    }

}