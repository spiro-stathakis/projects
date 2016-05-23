<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;
use yii\helpers\Json; 

class AjaxResponse extends Object
{

	
    private $_error; 
    private $_message; 
    private $_format; 
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    public function init()
    {
        $this->_error = true; 
        $this->_message = []; 
        $this->_format =  \yii\web\Response::FORMAT_JSON;  
        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    public function getError()
    {
       return $this->_error; 
    }
    /* ******************************************************************************************************* */ 
    public function getMessage()
    {
       return $this->_message; 
    }
    /* ******************************************************************************************************* */ 
    public function setError($data)
    {
        $allowed = [true,false] ; 
        if (! in_array($data, $allowed)) 
            throw new \yii\web\HttpException(500, sprintf('AjaxResponseComponent does not support %s', $key));
        $this->_error = $data; 

    }
    /* ******************************************************************************************************* */ 
    public function setMessage($data)
    {
            $this->_message = $data; 

    }
    /* ******************************************************************************************************* */ 
    public function sendContent()
    {
            \Yii::$app->response->format =$this->_format;
            echo Json::encode(['error'=>$this->_error, 
                                'message'=>$this->_message
                            ]);
            Yii::$app->end();
    }

    /* ******************************************************************************************************* */ 

}