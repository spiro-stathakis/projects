<?php

namespace frontend\modules\calendar\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\calendar\models\Event;

/**
 * EventSearch represents the model behind the search form about `frontend\modules\calendar\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'calendar_id', 'project_id', 'sort_order', 'status_id', 'old_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
        $query = Event::find();

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
            'calendar_id' => $this->calendar_id,
            'project_id' => $this->project_id,
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
