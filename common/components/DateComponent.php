<?php 
namespace common\components; 


use Yii; 
use yii\base\Object;


class DateComponent extends Object
{

	

    private $_myCalendars; 
    private $_myCalendarCollections; 
    private $_isoRegExDate = "/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/"; 
    private $_ukRegExDate = "/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/"; 
    private $_ukRegExDateTime = "/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4}) ([0-1]?[0-9]|[2][0-3]):([0-5][0-9])$/";
    private $_isoDateTimeFormat  = "Y-m-d H:i"; 
    private $_isoDateFormat  = "Y-m-d"; 
    private $_ukDateTimeFormat  = "d-m-Y H:i"; 
    private $_ukDateFormat  = "d-m-Y"; 
    private $_dateStruct = []; 
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    public function init()
    {
      
        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    public function timeStampToIsoDateTime($timestamp)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        return $date->format($this->_isoDateTimeFormat);
    
    }
    /* ******************************************************************************************************* */ 
    public function timestampToIsoDate($timestamp)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        return $date->format($this->_isoDateFormat);
    }
    /* ******************************************************************************************************* */ 
    public function ukDateTimeToTimestamp($dateTime)
    {
        if ($this->_isUkDateTime($dateTime))
            return \DateTime::createFromFormat($this->_ukDateTimeFormat,$dateTime)->getTimestamp();
        else 
            return $dateTime; 

    }
    /* ******************************************************************************************************* */ 
    public function timestampToUkDate($timestamp, $time=false)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        if ($time)
            return $date->format($this->_ukDateTimeFormat);
        else 
            return $date->format($this->_ukDateFormat);
    }
    /* ******************************************************************************************************* */ 
    public function isoDateToTimestamp($date)
    {
        if (! $this->_isIsoDate($date))
            return false; 

        
        return strtotime($date);      


    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
         

    public function isoToUkDate($date, $time=false)
    {
        $date = new \DateTime($date);
        if ($time)
            return $date->format($this->_ukDateTimeFormat); 
        else 
            return $date->format($this->_ukDateFormat);
    }
    /* ******************************************************************************************************* */ 
    private function _isUkDateTime($dateTime)
    {
        $return =  preg_match ($this->_ukRegExDateTime, $dateTime,$this->_dateStruct); 
        return  $return && ($this->_dateStruct[1] >= 12); 
    }
    /* ******************************************************************************************************* */ 
    private function _isUkDate($date)
    {
      
        $return =  preg_match ($this->_ukRegExDate, $date,$this->_dateStruct); 
        return  $return && ($this->_dateStruct[1] >= 12); 
        
    }
    /* ******************************************************************************************************* */ 
    private function _isIsoDate($date)
    {
      
        if (preg_match($this->_isoRegExDate, $date, $this->_dateStruct) == 1 )
            return true; 
        else 
            return false;   
    }
    /* ******************************************************************************************************* */ 
    
    
	
    /* ******************************************************************************************************* */ 
   
	/* ******************************************************************************************************* */ 
   
	/* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 

}