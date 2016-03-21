<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_member_type".
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
 * @property CollectionCollection[] $collectionCollections
 * @property ProjectCollection[] $projectCollections
 * @property UserCollection[] $userCollections
 */
class RefMemberType extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_member_type';
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
    public function getCollectionCollections()
    {
        return $this->hasMany(CollectionCollection::className(), ['member_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectCollections()
    {
        return $this->hasMany(ProjectCollection::className(), ['member_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCollections()
    {
        return $this->hasMany(UserCollection::className(), ['member_type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RefMemberTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefMemberTypeQuery(get_called_class());
    }
}
