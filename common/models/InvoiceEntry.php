<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_entry".
 *
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $resource_id
 * @property string $resource_other
 * @property integer $unit_cost
 * @property integer $qty
 * @property integer $total_cost
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $old_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefStatus $status
 * @property Invoice $invoice
 * @property Resource $resource
 */
class InvoiceEntry extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_entry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'resource_id', 'total_cost', 'created_at', 'created_by'], 'required'],
            [['invoice_id', 'resource_id', 'unit_cost', 'qty', 'total_cost', 'sort_order', 'status_id', 'old_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['resource_other'], 'string', 'max' => 4096],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
            [['resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resource::className(), 'targetAttribute' => ['resource_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'resource_id' => Yii::t('app', 'Resource ID'),
            'resource_other' => Yii::t('app', 'Resource Other'),
            'unit_cost' => Yii::t('app', 'Unit Cost'),
            'qty' => Yii::t('app', 'Qty'),
            'total_cost' => Yii::t('app', 'Total Cost'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status_id' => Yii::t('app', 'Status ID'),
            'old_id' => Yii::t('app', 'Old ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(RefStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResource()
    {
        return $this->hasOne(Resource::className(), ['id' => 'resource_id']);
    }

    /**
     * @inheritdoc
     * @return InvoiceEntryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceEntryQuery(get_called_class());
    }
}
