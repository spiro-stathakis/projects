<?php

namespace frontend\modules\screening\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\components\Types; 
/**
 * SubjectsSearch represents the model behind the search form about `common\models\Subjects`.
 */
class SubjectScreeningSearch extends \common\models\Subject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gp_opt_id', 'email_opt_id', 'sex_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['cubric_id', 'dob_yyyy','dob_mm','dob_dd','hash','screening_form_id', 'project_id', 'first_name', 'last_name', 'dob', 'email', 'telephone', 'address'], 'safe'],
        ];
    }

    /* ****************************************************************************************************** */ 
    public function getDays()
    {
        $arr = []; 
       
        for($i =1 ; $i <= 31 ; $i++ )
            $arr[sprintf('%s' , $i)] = sprintf('%s' , $i);
        return $arr;  
    }
    /* ****************************************************************************************************** */ 
    public function getMonths()
    {
        $arr = []; 
       
        for($i =1 ; $i <= 12 ; $i++ )
            $arr[sprintf('%s' , $i)] = sprintf('%s' , $i);
        return $arr;  
    }
    /* ****************************************************************************************************** */ 
    public function getYears()
    {
        $arr = []; 
        $year = date("Y"); 
        for($i = $year ; $i > ($year -100) ; $i-- )
           $arr[sprintf('%s' , $i)] = sprintf('%s' , $i); 
        return $arr;  
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
        $query = parent::find();

        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

       
        if (! isset($params['dob']))
            if (isset($this->dob_yyyy) && isset($this->dob_mm) && isset($this->dob_dd))
                $this->dob = sprintf('%s-%s-%s',$this->dob_yyyy,$this->dob_mm,$this->dob_dd  ); 
       

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        } 

        if (isset($params['hash']))
        
            $query->Where(['=','hash', $this->hash])
            ->andWhere(['=','status_id', Types::$status['active']['id']]); 
                 
        
        else 

            $query->Where(['=','first_name', $this->first_name])
                ->andWhere(['=','last_name', $this->last_name])
                ->andWhere(['=','dob', $this->dob])
                ->andWhere(['=','status_id', Types::$status['active']['id']]);

print_r($params); 

        

           
        
        return $dataProvider;
    }
}
