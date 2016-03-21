<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_collection".
 *
 * @property integer $id
 * @property integer $collection_id
 * @property integer $user_id
 * @property integer $member_type_id
 * @property integer $expiry
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefMemberType $memberType
 * @property Collection $collection
 * @property RefStatus $status
 * @property User $user
 */
class UserCollection extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_collection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collection_id', 'user_id', 'member_type_id'], 'required'],
            [['collection_id', 'user_id', 'member_type_id', 'expiry', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['member_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefMemberType::className(), 'targetAttribute' => ['member_type_id' => 'id']],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::className(), 'targetAttribute' => ['collection_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'collection_id' => Yii::t('app', 'Collection ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'member_type_id' => Yii::t('app', 'Member Type ID'),
            'expiry' => Yii::t('app', 'Expiry'),
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
    public function getMemberType()
    {
        return $this->hasOne(RefMemberType::className(), ['id' => 'member_type_id']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return UserCollectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserCollectionQuery(get_called_class());
    }
}
