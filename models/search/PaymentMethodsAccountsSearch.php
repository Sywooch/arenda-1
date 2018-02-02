<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PaymentMethods;

/**
 * PaymentMethodsSearch represents the model behind the search form of `app\models\PaymentMethods`.
 */
class PaymentMethodsAccountsSearch extends PaymentMethods
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'user_id', 'type', 'status'], 'integer'],
			[['data'], 'safe'],
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
		$query = PaymentMethods::find();

		$query->andWhere(['type' => self::TYPE_BANK_ACCOUNT]);

		if (array_key_exists('user_id', $params)) {
			$query->andWhere(['user_id' => (int)$params['user_id']]);
		}

		$dataProvider = new ActiveDataProvider([
			'query'      => $query,
			'pagination' => false,
			'sort'       => [
				'defaultOrder' => ['type' => SORT_ASC],
			],
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id'      => $this->id,
			'user_id' => $this->user_id,
			'type'    => $this->type,
			'status'  => $this->status,
		]);

		$query->andFilterWhere(['like', 'data', $this->data]);

		return $dataProvider;
	}

}