<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "collection".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $description
 * @property integer $collection_type_id
 * @property integer $membership_duration
 * @property integer $member_count
 * @property integer $manager_count
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Calendar[] $calendars
 * @property RefCollectionType $collectionType
 * @property RefStatus $status
 * @property CollectionCollection[] $collectionCollections
 * @property CollectionCollection[] $collectionCollections0
 * @property ProjectCollection[] $projectCollections
 * @property Resource[] $resources
 * @property ScreeningForm[] $screeningForms
 * @property UserCollection[] $userCollections
 */
class Collection extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'collection_type_id', 'created_at', 'created_by'], 'required'],
            [['collection_type_id', 'membership_duration', 'member_count', 'manager_count', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 4096],
            [['collection_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefCollectionType::className(), 'targetAttribute' => ['collection_type_id' => 'id']],
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
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'description' => Yii::t('app', 'Description'),
            'collection_type_id' => Yii::t('app', 'Collection Type ID'),
            'membership_duration' => Yii::t('app', 'Membership Duration'),
            'member_count' => Yii::t('app', 'Member Count'),
            'manager_count' => Yii::t('app', 'Manager Count'),
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
        return $this->hasMany(Calendar::className(), ['collection_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionType()
    {
        return $this->hasOne(RefCollectionType::className(), ['id' => 'collection_type_id']);
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
    public function getCollectionCollections()
    {
        return $this->hasMany(CollectionCollection::className(), ['child_collection_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionCollections0()
    {
        return $this->hasMany(CollectionCollection::className(), ['parent_collection_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectCollections()
    {
        return $this->hasMany(ProjectCollection::className(), ['collection_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        return $this->hasMany(Resource::className(), ['collection_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningForms()
    {
        return $this->hasMany(ScreeningForm::className(), ['collection_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCollections()
    {
        return $this->hasMany(UserCollection::className(), ['collection_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CollectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CollectionQuery(get_called_class());
    }
}
