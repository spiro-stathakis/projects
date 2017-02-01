<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property integer $invoice_number
 * @property integer $project_id
 * @property integer $publish_status_id
 * @property integer $vat_status_id
 * @property integer $amount
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $old_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefStatus $status
 * @property Project $project
 * @property RefBoolean $publishStatus
 * @property RefBoolean $vatStatus
 * @property InvoiceEntry[] $invoiceEntries
 */
class Invoice extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_number', 'project_id', 'publish_status_id', 'vat_status_id', 'amount', 'created_at', 'created_by'], 'required'],
            [['invoice_number', 'project_id', 'publish_status_id', 'vat_status_id', 'amount', 'sort_order', 'status_id', 'old_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['publish_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['publish_status_id' => 'id']],
            [['vat_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['vat_status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'invoice_number' => Yii::t('app', 'Invoice Number'),
            'project_id' => Yii::t('app', 'Project ID'),
            'publish_status_id' => Yii::t('app', 'Publish Status ID'),
            'vat_status_id' => Yii::t('app', 'Vat Status ID'),
            'amount' => Yii::t('app', 'Amount'),
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublishStatus()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'publish_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVatStatus()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'vat_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceEntries()
    {
        return $this->hasMany(InvoiceEntry::className(), ['invoice_id' => 'id']);
    }

    public function getResearchers()
    {
        return $this->hasOne(User::className(), ['id' => 'pi_id'])->via('project');
    }


    /**
     * @inheritdoc
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }
}
