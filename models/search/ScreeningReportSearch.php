<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ScreeningReport;

class ScreeningReportSearch extends ScreeningReport
{
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_first', 'name_last', 'name_middle', 'status', 'type'], 'safe'],
        ];
    }
    
    public function scenarios()
	{
		return [
			self::SCENARIO_DEFAULT => ['type', 'name_first', 'name_last', 'name_middle', 'status'],
		];
	}
    
    public function search($params)
    {
		$query = ScreeningReport::find();
		$query->orderBy('id DESC');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		$query->andFilterWhere(['user_id' => $this->user_id]);
		
		if (!$this->validate()) {
			return $dataProvider;
		}

		$query
			->andFilterWhere(['status' => $this->status])
			->andFilterWhere(['type' => $this->type])
			->andFilterWhere(['like', 'name_first', $this->name_first])
			->andFilterWhere(['like', 'name_last', $this->name_last])
			->andFilterWhere(['like', 'name_middle', $this->name_middle]);

		return $dataProvider;
    }
}
