<?php

namespace frontend\modules\calendar\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\calendar\models\EventEntry;

/**
 * EventEntrySearch represents the model behind the search form about `frontend\modules\calendar\models\EventEntry`.
 */
class EventEntrySearch extends EventEntry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'event_id', 'booking_status_id', 'start_timestamp', 'end_timestamp', 'all_day_option_id', 'confirm_by', 'confirm_date', 'sort_order', 'status_id', 'old_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description'], 'safe'],
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
        $query = EventEntry::find();

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
            'event_id' => $this->event_id,
            'booking_status_id' => $this->booking_status_id,
            'start_timestamp' => $this->start_timestamp,
            'end_timestamp' => $this->end_timestamp,
            'all_day_option_id' => $this->all_day_option_id,
            'confirm_by' => $this->confirm_by,
            'confirm_date' => $this->confirm_date,
            'sort_order' => $this->sort_order,
            'status_id' => $this->status_id,
            'old_id' => $this->old_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
