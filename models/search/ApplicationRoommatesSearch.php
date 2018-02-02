<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApplicationRoommates;
use app\models\Ads;
use app\models\User;

/**
 * ApplicationRoommatesSearch represents the model behind the search form of `app\models\ApplicationRoommates`.
 */
class ApplicationRoommatesSearch extends ApplicationRoommates
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['id', 'application_id'], 'integer'],
                [['first_name', 'last_name', 'email'], 'safe'],
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
        $query = ApplicationRoommates::find();
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
            'application_id' => $this->application_id,
        ]);
        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'email', $this->email]);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param integer $adId
     *
     * @return ActiveDataProvider
     */
    public function searchByAd($params, $adId)
    {
        $query = ApplicationRoommates::find();

        $query->joinWith(['application' => function($query) use ($adId) {
                $query->where(['user_id' => yii::$app->user->id]);
                $query->joinWith([
                    'ad' => function($query) use ($adId) {
                        $query->where([Ads::tableName() . '."id"' => $adId]);
                        return $query;
                    }
                ]);
                return $query;
            }]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

}
