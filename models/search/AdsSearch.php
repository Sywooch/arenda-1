<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ads;

/**
 * AdsSearch represents the model behind the search form of `app\models\Ads`.
 */
class AdsSearch extends Ads
{
	public $house_type = null;
	public $building_type = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'real_estate_id', 'house_type', 'accommodation_type', 'number_of_bedrooms', 'separate_bathroom', 'combined_bathroom', 'house_floors', 'location_floor', 'building_type', 'number_of_rooms', 'condition', 'watch_statistics', 'rent_term', 'rent_available_date', 'rent_pledge', 'check_credit_reports', 'check_biographical_information'], 'integer'],
            [['title', 'description', 'place_add_to', 'status'], 'safe'],
            [['rent_cost_per_month'], 'number'],
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
        $query = Ads::find();

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
            'id' => $this->id,
            'real_estate_id' => $this->real_estate_id,
            'house_type' => $this->house_type,
            'accommodation_type' => $this->accommodation_type,
            'number_of_bedrooms' => $this->number_of_bedrooms,
            'separate_bathroom' => $this->separate_bathroom,
            'combined_bathroom' => $this->combined_bathroom,
            'house_floors' => $this->house_floors,
            'location_floor' => $this->location_floor,
            'building_type' => $this->building_type,
            'number_of_rooms' => $this->number_of_rooms,
            'condition' => $this->condition,
            'watch_statistics' => $this->watch_statistics,
            'rent_cost_per_month' => $this->rent_cost_per_month,
            'rent_term' => $this->rent_term,
            'rent_available_date' => $this->rent_available_date,
            'rent_pledge' => $this->rent_pledge,
            'check_credit_reports' => $this->check_credit_reports,
            'check_biographical_information' => $this->check_biographical_information,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'place_add_to', $this->place_add_to]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param integer $userId
     *
     * @return ActiveDataProvider
     */
    public function searchMy($params, $userId)
    {
        $query = Ads::find()
                ->innerJoinWith(['estate' => function($query) use ($userId) {
                $query->andWhere(['user_id' => (int) $userId]);
            }]);
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
                    'id' => $this->id,
                    'real_estate_id' => $this->real_estate_id,
                    'house_type' => $this->house_type,
                    'accommodation_type' => $this->accommodation_type,
                    'number_of_bedrooms' => $this->number_of_bedrooms,
                    'separate_bathroom' => $this->separate_bathroom,
                    'combined_bathroom' => $this->combined_bathroom,
                    'house_floors' => $this->house_floors,
                    'location_floor' => $this->location_floor,
                    'building_type' => $this->building_type,
                    'number_of_rooms' => $this->number_of_rooms,
                    'condition' => $this->condition,
                    'watch_statistics' => $this->watch_statistics,
                    'rent_cost_per_month' => $this->rent_cost_per_month,
                    'rent_term' => $this->rent_term,
                    'rent_available_date' => $this->rent_available_date,
                    'rent_pledge' => $this->rent_pledge,
                    'check_credit_reports' => $this->check_credit_reports,
                    'check_biographical_information' => $this->check_biographical_information,
                    'status' => $this->status,
                ]);

                $query->andFilterWhere(['like', 'title', $this->title])
                        ->andFilterWhere(['like', 'description', $this->description])
                        ->andFilterWhere(['like', 'place_add_to', $this->place_add_to]);

                return $dataProvider;
            }

        }        