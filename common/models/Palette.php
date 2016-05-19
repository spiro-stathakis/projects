<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "palette".
 *
 * @property integer $id
 * @property string $hex_code
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
 * @property RefStatus $status
 */
class Palette extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'palette';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hex_code', 'name', 'description', 'status_id', 'created_at', 'created_by'], 'required'],
            [['sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['hex_code', 'name', 'description'], 'string', 'max' => 255],
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
            'hex_code' => Yii::t('app', 'Hex Code'),
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
    public function getStatus()
    {
        return $this->hasOne(RefStatus::className(), ['id' => 'status_id']);
    }
}
