<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdBoard;

class AdBoardSearch extends AdBoard
{
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'enabled'], 'safe'],
        ];
    }
    
    public function search($params)
    {
		$query = AdBoard::find();
		$query->orderBy('name ASC');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);
		
		if (!$this->validate()) {
			return $dataProvider;
		}

		$query
			->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'code', $this->code])
			->andFilterWhere(['enabled' => $this->enabled]);

		return $dataProvider;
    }
}
