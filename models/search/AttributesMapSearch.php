<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AttributesMap;

/**
 * AttributesMapSearch represents the model behind the search form of `app\models\AttributesMap`.
 */
class AttributesMapSearch extends AttributesMap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'input_type', 'purpose', 'parent', 'position'], 'integer'],
            [['label', 'hint', 'before', 'after'], 'safe'],
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
        $query = AttributesMap::find();

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
            'input_type' => $this->input_type,
            'purpose' => $this->purpose,
            'parent' => $this->parent,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'hint', $this->hint])
            ->andFilterWhere(['like', 'before', $this->before])
            ->andFilterWhere(['like', 'after', $this->after]);

        return $dataProvider;
    }
}
