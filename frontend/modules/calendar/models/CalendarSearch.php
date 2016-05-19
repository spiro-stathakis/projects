<?php

namespace app\modules\calendar\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\calendar\models\Calendar;

/**
 * CalendarSearch represents the model behind the search form about `frontend\modules\calendar\models\Calendar`.
 */
class CalendarSearch extends Calendar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'collection_id', 'project_option_id', 'allow_overlap_option_id', 'read_only_option_id', 'advance_limit', 'old_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description', 'location', 'start_hour', 'start_min', 'end_hour', 'end_min', 'hex_code'], 'safe'],
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
        $query = Calendar::find();

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
            'collection_id' => $this->collection_id,
            'project_option_id' => $this->project_option_id,
            'allow_overlap_option_id' => $this->allow_overlap_option_id,
            'read_only_option_id' => $this->read_only_option_id,
            'advance_limit' => $this->advance_limit,
            'old_id' => $this->old_id,
            'sort_order' => $this->sort_order,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'start_hour', $this->start_hour])
            ->andFilterWhere(['like', 'start_min', $this->start_min])
            ->andFilterWhere(['like', 'end_hour', $this->end_hour])
            ->andFilterWhere(['like', 'end_min', $this->end_min])
            ->andFilterWhere(['like', 'hex_code', $this->hex_code]);

        return $dataProvider;
    }
}
