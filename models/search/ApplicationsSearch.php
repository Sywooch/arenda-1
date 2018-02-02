<?php

namespace app\models\search;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Applications;
use app\models\Ads;
use app\models\RealEstate;

/**
 * ApplicationsSearch represents the model behind the search form of `app\models\Applications`.
 */
class ApplicationsSearch extends Applications
{
	public $activeAdsOnly = false;
	public $street;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'user_id', 'ad_id', 'date_created', 'status'], 'integer'],
			[['data','street'], 'safe'],
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
		$query = Applications::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id'           => $this->id,
			'user_id'      => $this->user_id,
			'ad_id'        => $this->ad_id,
			'date_created' => $this->date_created,
			'status'       => $this->status,
		]);

		$lTName = Applications::tableName();
		if ($this->street !== null) {
			$adTableName = Ads::tableName();
			$estateTableName = RealEstate::tableName();

			$query->innerJoin(['ad' => $adTableName], $lTName.'.ad_id = ad.id');
			$query->innerJoin(['es' => $estateTableName], 'ad.real_estate_id = es.id');
			$query->andFilterWhere(['ilike', 'es.street',  $this->street]);
		}

		$query->andFilterWhere(['like', 'data', $this->data]);

		return $dataProvider;
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function searchForManager($params)
	{
		$query = Ads::find();
		$query->alias('t');

		$query->joinWith(['applications', 'estate' => function ($query) {
			return $query;
		}]);

		$estateTableName = RealEstate::tableName();

		$query->andWhere([$estateTableName . '."user_id"' => $this->user_id]);

		if ($this->activeAdsOnly) {
			$query->andWhere(['t.status' => Ads::STATUS_ACTIVE]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$lTName = Applications::tableName();
		if ($this->street !== null) {
			$adTableName = Ads::tableName();
			$estateTableName = RealEstate::tableName();

			$query->innerJoin(['ad' => $adTableName], $lTName.'.ad_id = ad.id');
			$query->innerJoin(['es' => $estateTableName], 'ad.real_estate_id = es.id');
			$query->andFilterWhere(['ilike', 'es.street',  $this->street]);
		}

		return $dataProvider;
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function searchForCustomer($params)
	{
		$query = Applications::find();

		$query->joinWith(['ad']);

		if ($this->activeAdsOnly) {
			$adsTableName = Ads::tableName();
			$query->andWhere([$adsTableName . '.status' => Ads::STATUS_ACTIVE]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);
		if (!$this->validate()) {
			return $dataProvider;
		}
		$lTName = Applications::tableName();
		if ($this->street !== null) {
			$adTableName = Ads::tableName();
			$estateTableName = RealEstate::tableName();

			$query->innerJoin(['ad' => $adTableName], $lTName.'.ad_id = ad.id');
			$query->innerJoin(['es' => $estateTableName], 'ad.real_estate_id = es.id');
			$query->andFilterWhere(['ilike', 'es.street',  $this->street]);
		}

		$query->andFilterWhere([
			$lTName.'.user_id' => $this->user_id,
		]);

		return $dataProvider;
	}

}
