<?php

namespace app\models\search;

use app\models\LeaseContractParticipants;
use app\models\RealEstate;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LeaseContracts;

/**
 * LeaseContractsSearch represents the model behind the search form of `app\models\LeaseContracts`.
 */
class LeaseContractsSearch extends LeaseContracts
{
	public $participant_id = null;
	public $street = null;
	public $disabledOnly = false;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'user_id', 'real_estate_id', 'payment_method_id', 'payment_date', 'date_created', 'date_begin', 'lease_term'], 'integer'],
			[['price_per_month'], 'number'],
			[['payment_method_id','street'], 'safe'],
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
		$query = LeaseContracts::find()->orderBy('id ASC');

		// add conditions that should always apply here

		if ($this->disabledOnly) {
			$query->andWhere(['status' => self::STATUS_DISABLED]);
			$query->orWhere(['status' => self::STATUS_IN_DISABLE]);
		} else {
			$query->andWhere(['NOT IN', 'status', [
				self::STATUS_DRAFT,
				self::STATUS_DISABLED,
				//self::STATUS_IN_DISABLE,
			]]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		if ($this->participant_id !== null) {
			$query->joinWith(['participants']);

			$participantsTableName = LeaseContractParticipants::tableName();
			$query->andWhere([$participantsTableName . '.user_id' => $this->participant_id]);
		}

		if ($this->street !== null) {
			$query->joinWith(['estate']);
			$estatesTableName = RealEstate::tableName();
			$query->andFilterWhere(['ilike', $estatesTableName.'.street',  $this->street]);
		}
		$lTName = LeaseContracts::tableName();
		// grid filtering conditions
		$query->andFilterWhere([
			'id'                => $this->id,
			$lTName.'.user_id'  => $this->user_id,
			'real_estate_id'    => $this->real_estate_id,
			'payment_method_id' => $this->payment_method_id,
			'price_per_month'   => $this->price_per_month,
			'payment_date'      => $this->payment_date,
			'date_created'      => $this->date_created,
			'date_begin'        => $this->date_begin,
			'lease_term'        => $this->lease_term,
		]);

		return $dataProvider;
	}

}