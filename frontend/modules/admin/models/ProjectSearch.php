<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Project;

/**
 * ProjectSearch represents the model behind the search form about `common\models\Project`.
 */
class ProjectSearch extends \common\models\ProjectSearch 
{
    /**
     * @inheritdoc
     */
    
    public $researcher; 

    public function rules()
    {
        return [
            [['id', 'csa_id', 'pi_id', 'collection_id', 'resource_collection_id', 'wefo_id', 'app_received', 'cog_approval', 'presentation', 'ethics_approval', 'risk_assessment', 'rules_procedure', 'mri_time', 'meg_time', 'old_id', 'project_status_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'code', 'funding_number', 'funding_code', 'ethics_number','researcher'], 'safe'],
        ];
    }

    
    public function search($params)
    {
        $query = Project::find();
        $query->joinWith(['pi']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['researcher'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['user.first_name' => SORT_ASC],
        'desc' => ['user.first_name' => SORT_DESC],
    ];

        $dataProvider->sort->attributes['title'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['project.first_name' => SORT_ASC],
        'desc' => ['project.first_name' => SORT_DESC],
    ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'project.id' => $this->id,
            'project.csa_id' => $this->csa_id,
            'project.pi_id' => $this->pi_id,
            'collection_id' => $this->collection_id,
            'resource_collection_id' => $this->resource_collection_id,
            'wefo_id' => $this->wefo_id,
            'app_received' => $this->app_received,
            'cog_approval' => $this->cog_approval,
            'presentation' => $this->presentation,
            'ethics_approval' => $this->ethics_approval,
            'risk_assessment' => $this->risk_assessment,
            'rules_procedure' => $this->rules_procedure,
            'mri_time' => $this->mri_time,
            'meg_time' => $this->meg_time,
            'old_id' => $this->old_id,
            'project_status_id' => $this->project_status_id,
            'sort_order' => $this->sort_order,
            'project.status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'project.title', $this->title])
            ->andFilterWhere(['like', 'project.code', $this->code])
            ->andFilterWhere(['like', 'project.funding_number', $this->funding_number])
            ->andFilterWhere(['like', 'project.funding_code', $this->funding_code])
            ->andFilterWhere(['like', 'project.ethics_number', $this->ethics_number])
            //->andFilterWhere(['like', 'pi.first_name', $this->pi->first_name]);
            ->andFilterWhere(['like', 'user.last_name', $this->researcher])
            ->orFilterWhere(['like', 'user.first_name', $this->researcher]);
        $query->orderBy('project.created_at DESC');
        return $dataProvider;
    }
}
