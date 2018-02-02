<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RealEstate;

/**
 * RealEstateSearch represents the model behind the search form of `app\models\RealEstate`.
 */
class RealEstateSearch extends RealEstate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'total_area', 'corps', 'flat', 'metro_id'], 'integer'],
            [['city', 'street', 'cover_image'], 'safe'],
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
        $query = RealEstate::find();
	    $query->orderBy('id DESC');

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
            'user_id' => $this->user_id,
            'total_area' => $this->total_area,
            'corps' => $this->corps,
            'flat' => $this->flat,
            'metro_id' => $this->metro_id,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['ilike', 'street', $this->street])
            ->andFilterWhere(['like', 'cover_image', $this->cover_image]);

        return $dataProvider;
    }
}
