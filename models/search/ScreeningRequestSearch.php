<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ScreeningRequest;

class ScreeningRequestSearch extends ScreeningRequest
{
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_first', 'name_last', 'email'], 'safe'],
        ];
    }
    
    public function search($params)
    {
		$query = ScreeningRequest::find();
		$query->orderBy('id DESC');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		$query->andFilterWhere([
			'user_id' => $this->user_id,
		]);
		
		if (!$this->validate()) {
			return $dataProvider;
		}

		$query
			->andFilterWhere(['like', 'name_first', $this->name_first])
			->andFilterWhere(['like', 'name_last', $this->name_last])
			->andFilterWhere(['like', 'email', $this->email]);

		return $dataProvider;
    }
}
