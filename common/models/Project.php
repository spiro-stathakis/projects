<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property integer $csa_id
 * @property integer $pi_id
 * @property integer $wefo_id
 * @property string $name
 * @property string $code
 * @property string $funding_number
 * @property string $funding_code
 * @property integer $app_received
 * @property integer $cog_approval
 * @property integer $presentation
 * @property integer $ethics_approval
 * @property string $ethics_number
 * @property integer $risk_assessment
 * @property integer $rules_procedure
 * @property integer $mri_time
 * @property integer $meg_time
 * @property integer $old_id
 * @property integer $project_status_id
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefWefo $wefo
 * @property User $csa
 * @property User $pi
 * @property RefProjectStatus $projectStatus
 * @property RefStatus $status
 * @property ProjectCollection[] $projectCollections
 * @property ScreeningEntry[] $screeningEntries
 */
class Project extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['csa_id', 'pi_id', 'wefo_id', 'name', 'code', 'funding_number', 'funding_code', 'app_received', 'cog_approval', 'presentation', 'ethics_approval', 'ethics_number', 'risk_assessment', 'rules_procedure', 'mri_time', 'meg_time', 'old_id', 'project_status_id', 'created_at', 'created_by'], 'required'],
            [['csa_id', 'pi_id', 'wefo_id', 'app_received', 'cog_approval', 'presentation', 'ethics_approval', 'risk_assessment', 'rules_procedure', 'mri_time', 'meg_time', 'old_id', 'project_status_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'code', 'funding_number', 'funding_code', 'ethics_number'], 'string', 'max' => 255],
            [['wefo_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefWefo::className(), 'targetAttribute' => ['wefo_id' => 'id']],
            [['csa_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['csa_id' => 'id']],
            [['pi_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['pi_id' => 'id']],
            [['project_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProjectStatus::className(), 'targetAttribute' => ['project_status_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'csa_id' => Yii::t('app', 'Csa ID'),
            'pi_id' => Yii::t('app', 'Pi ID'),
            'wefo_id' => Yii::t('app', 'Wefo ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'funding_number' => Yii::t('app', 'Funding Number'),
            'funding_code' => Yii::t('app', 'Funding Code'),
            'app_received' => Yii::t('app', 'App Received'),
            'cog_approval' => Yii::t('app', 'Cog Approval'),
            'presentation' => Yii::t('app', 'Presentation'),
            'ethics_approval' => Yii::t('app', 'Ethics Approval'),
            'ethics_number' => Yii::t('app', 'Ethics Number'),
            'risk_assessment' => Yii::t('app', 'Risk Assessment'),
            'rules_procedure' => Yii::t('app', 'Rules Procedure'),
            'mri_time' => Yii::t('app', 'Mri Time'),
            'meg_time' => Yii::t('app', 'Meg Time'),
            'old_id' => Yii::t('app', 'Old ID'),
            'project_status_id' => Yii::t('app', 'Project Status ID'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status_id' => Yii::t('app', 'Status ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWefo()
    {
        return $this->hasOne(RefWefo::className(), ['id' => 'wefo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCsa()
    {
        return $this->hasOne(User::className(), ['id' => 'csa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPi()
    {
        return $this->hasOne(User::className(), ['id' => 'pi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStatus()
    {
        return $this->hasOne(RefProjectStatus::className(), ['id' => 'project_status_id']);
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
    public function getProjectCollections()
    {
        return $this->hasMany(ProjectCollection::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningEntries()
    {
        return $this->hasMany(ScreeningEntry::className(), ['project_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
}
