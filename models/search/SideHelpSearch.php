<?php

namespace app\models\search;

use app\models\SideHelp;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SideHelpSearch represents the model behind the search form of `app\models\SideHelp`.
 */
class SideHelpSearch extends SideHelp
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'status'], 'integer'],
			[['content', 'url'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = SideHelp::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id'     => $this->id,
			'status' => $this->status,
		]);

		$query->andFilterWhere(['like', 'content', $this->content])
			->andFilterWhere(['like', 'url', $this->url]);

		return $dataProvider;
	}
}
