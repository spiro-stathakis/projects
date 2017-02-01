<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Invoice;

/**
 * InvoiceSearch represents the model behind the search form about `common\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{

    public $project_code; 
    public $researcher; 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice_number', 'project_id', 'publish_status_id', 'vat_status_id', 'amount', 'sort_order', 'status_id', 'old_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['project_code','researcher'], 'safe'],
            

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
        $query = Invoice::find();
        $query->joinWith(['project','researchers']);
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
            'invoice.id' => $this->id,
            'invoice.invoice_number' => $this->invoice_number,
            'invoice.project_id' => $this->project_id,
            'invoice.publish_status_id' => $this->publish_status_id,
            'invoice.vat_status_id' => $this->vat_status_id,
            'invoice.amount' => $this->amount,
            'invoice.sort_order' => $this->sort_order,
            'invoice.status_id' => $this->status_id,
            'invoice.old_id' => $this->old_id,
            'invoice.created_at' => $this->created_at,
            'invoice.updated_at' => $this->updated_at,
            'invoice.created_by' => $this->created_by,
            'invoice.updated_by' => $this->updated_by,
        ]);
         $query->andFilterWhere(['like', 'project.code', $this->project_code])
           ->andFilterWhere(['like', 'user.last_name', $this->researcher])
            ->orFilterWhere(['like', 'user.first_name', $this->researcher]);
        $query->orderBy('invoice.created_at DESC');
        return $dataProvider;

        return $dataProvider;
    }
}
