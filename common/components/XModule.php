<?php

namespace common\components;


class XModule extends \yii\base\Module
{
    
	public function init()
    {
    	
        parent::init();

    }

    /* *************************************************************** */ 
    

    /* *************************************************************** */ 
   
    /* *************************************************************** */ 
    public function addJsConfig($name,$value)
	{
		$this->_jsConfig[$name] = $value;
			
	}
	/* *************************************************************** */ 
	public function getJsConfig()
	{
		return $this->_jsConfig; 
	} 
	/* *************************************************************** */ 
}
