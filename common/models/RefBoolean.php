<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_boolean".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Calendar[] $calendars
 * @property Calendar[] $calendars0
 * @property Calendar[] $calendars1
 * @property Event[] $events
 * @property EventEntry[] $eventEntries
 * @property RefStatus $status
 * @property ScreeningEntry[] $screeningEntries
 * @property ScreeningForm[] $screeningForms
 * @property ScreeningQuestion[] $screeningQuestions
 * @property Subject[] $subjects
 * @property Subject[] $subjects0
 */
class RefBoolean extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_boolean';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'description', 'status_id', 'created_at', 'created_by'], 'required'],
            [['sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'description'], 'string', 'max' => 255],
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
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
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
    public function getCalendars()
    {
        return $this->hasMany(Calendar::className(), ['allow_overlap_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendars0()
    {
        return $this->hasMany(Calendar::className(), ['project_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendars1()
    {
        return $this->hasMany(Calendar::className(), ['read_only_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['all_day_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventEntries()
    {
        return $this->hasMany(EventEntry::className(), ['all_day_option_id' => 'id']);
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
    public function getScreeningEntries()
    {
        return $this->hasMany(ScreeningEntry::className(), ['contraindication_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningForms()
    {
        return $this->hasMany(ScreeningForm::className(), ['signature_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningQuestions()
    {
        return $this->hasMany(ScreeningQuestion::className(), ['tristate_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subject::className(), ['email_opt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects0()
    {
        return $this->hasMany(Subject::className(), ['gp_opt_id' => 'id']);
    }
}
