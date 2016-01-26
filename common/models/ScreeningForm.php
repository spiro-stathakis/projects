<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "screening_form".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property integer $collection_id
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ScreeningEntry[] $screeningEntries
 * @property Collection $collection
 * @property RefStatus $status
 * @property ScreeningQuestion[] $screeningQuestions
 */
class ScreeningForm extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'screening_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'collection_id', 'created_at', 'created_by'], 'required'],
            [['collection_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['title', 'description'], 'string', 'max' => 4096],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::className(), 'targetAttribute' => ['collection_id' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'collection_id' => Yii::t('app', 'Collection ID'),
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
    public function getScreeningEntries()
    {
        return $this->hasMany(ScreeningEntry::className(), ['screening_form_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::className(), ['id' => 'collection_id']);
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
    public function getScreeningQuestions()
    {
        return $this->hasMany(ScreeningQuestion::className(), ['screening_form_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ScreeningFormQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreeningFormQuery(get_called_class());
    }
}
