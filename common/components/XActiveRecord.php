<?php
namespace common\components;

//use Yii;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;

use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior; 
/**
 * Site controller
 */
abstract class XActiveRecord extends \yii\db\ActiveRecord
{
    
    	public function behaviors()
    	{
    		return [
    				   'timestamp'=> [
        					'class'=>TimestampBehavior::className(), 
        					'attributes'=>[
        						parent::EVENT_BEFORE_INSERT => ['created_at'], 
        						parent::EVENT_BEFORE_UPDATE => ['updated_at'], 
        							
        					   ]
                            ],
    				
    				    'blameable'=>[
            					'class'=>BlameableBehavior::className(), 
            					'createdByAttribute'=>'created_by', 
                                 'updatedByAttribute'=>'updated_by', 
                                   
        					   
        				    ],
                    ];
    			 

    		

    	}


}
