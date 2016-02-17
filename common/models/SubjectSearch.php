<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Subject;

/**
 * SubjectsSearch represents the model behind the search form about `common\models\Subjects`.
 */
class SubjectScreeningSearch extends Subject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gp_opt_id', 'email_opt_id', 'sex_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['cubric_id', 'dob_yyyy','dob_mm','dob_dd','screening_form_id', 'project_id', 'first_name', 'last_name', 'dob', 'email', 'telephone', 'address'], 'safe'],
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
        $query = Subject::find();

        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

       
        if (! isset($this->dob))
            if (isset($this->dob_yyyy) && isset($this->dob_mm) && isset($this->dob_dd))
                $this->dob = sprintf('%s-%s-%s',$this->dob_yyyy,$this->dob_mm,$this->dob_dd  ); 
       

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        } 
        print_r($this->dob); 
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'dob' => $this->dob,
            'screening_form_id'=>$this->screening_form_id, 
            'project_id'=>$this->project_id, 
            'gp_opt_id' => $this->gp_opt_id,
            'email_opt_id' => $this->email_opt_id,
            'sex_id' => $this->sex_id,
            'sort_order' => $this->sort_order,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->Where(['=','first_name', $this->first_name])
            ->andWhere(['=','last_name', $this->last_name])
            ->andWhere(['=','dob', $this->dob]);
           

        return $dataProvider;
    }
}
