<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;

/* 
Function: 

isManager: Returns boolean 
isMember:  Returns boolean 
getEvents: Get events appropriate to user context 
getMyCalendarList: Return array ['id'=>'name'] of items that is appropriate to user context AND selected to view
getTheCalendarList: Return array ['id'=>'name'] of items that is appropriate to user context 
getMyCalendars: Return array of records that is appropriate to user context 


*/ 
class CalendarComponent extends Object
{

	

    private $_myCalendars; 
    private $_myCalendarList; 
    private $_theCalendarList; 

    
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    
    public function init()
    {
      
        return parent::init(); 
    }
    
    /* ******************************************************************************************************* */ 
    
    public function isManager($calendar_id)
    {
        $return = false; 
        foreach($this->myCalendars as $rec)
            if ($rec['member_type_id'] == Types::$member_type['manager']['id'] && 
                $rec['calendar_id'] == $calendar_id 
            )
                $return = true; 
        
        return $return; 
    }
    
    /* ******************************************************************************************************* */ 
    
    public function isMember($calendar_id)
    {
        $return = false; 
        foreach($this->myCalendars  as $rec)
            if ($rec['member_type_id'] == Types::$member_type['member']['id'] && 
                $rec['calendar_id'] == $calendar_id 
            )
                $return = true; 
        
        return $return; 


    }
    
    /* ******************************************************************************************************* */ 
    
    public function getEvents($start,$end)
    {
        return $this->_getEvents($start, $end); 
        
    }
    
    /* ******************************************************************************************************* */ 
    
    public function getMyCalendarList()
    {
        if ($this->_myCalendarList == null)
        {
            $this->_myCalendarList = [];   
            foreach($this->myCalendars as $rec)
                if ($rec['display_option_id'] == Types::$boolean['true']['id'] || $rec['display_option_id'] == null )
                    $this->_myCalendarList[$rec['calendar_id']] = $rec['calendar_title'];
        }
        return $this->_myCalendarList; 


    }
	
    
	/* ******************************************************************************************************* */ 
   
    public function getTheCalendarList()
    {
        

        if ($this->_theCalendarList == null) 
            foreach($this->myCalendars as $rec)
               $this->_theCalendarList[$rec['calendar_id']] = $rec['calendar_title'];
        
        return $this->_theCalendarList; 

    }

    /* ******************************************************************************************************* */ 
   

    public function  getMyCalendars()
	{

        if ($this->_myCalendars == null) 
            $this->_myCalendars = $this->_getMyCalendars(); 

        return $this->_myCalendars; 
    }
	
    /* ******************************************************************************************************* */ 
    





    /* ******************************************************************************************************* */ 
    
    /*                                          PRIVATE FUNCTIONS                                              */ 

    /* ******************************************************************************************************* */ 
    

    private function _getEvents($start, $end)
         {
            $data   = (new \yii\db\Query())
                ->select([
                    'e.id as event_id' , 'e.title as event_title',
                    'e.description as event_description' , 'e.calendar_id', 
                    'e.project_id' , 
                    'ee.id as event_entry_id' , 'ee.title as event_entry_title', 
                    'ee.description as event_entry_description', 'ee.booking_status_id', 
                    'ee.start_timestamp' , 'ee.end_timestamp' , 'ee.all_day_option_id' , 
                    'c.hex_code', 
                    ])
                ->from('event e')
                ->join('LEFT JOIN','calendar c' , 'e.calendar_id=c.id')
                ->join('LEFT JOIN', 'event_entry ee' , 'ee.event_id=e.id')
                ->join('LEFT JOIN','ref_booking_status rbs', 'ee.booking_status_id=rbs.id')
                ->where('ee.start_timestamp >= :start AND ee.end_timestamp <= :end')
                 ->addParams([':start'=>$start, 
                             ':end'=>$end 
                        ])
                ->all();

         return  $data; 

        }
    /* ******************************************************************************************************* */ 
    
    private function _getMyCalendars()
    {

        $select =       ['cal.id as calendar_id', 'cal.collection_id', 
                        'cal.title as calendar_title',
                        'col.title  as collection_title',
                        'cal.project_option_id', 
                        'cal.allow_overlap_option_id', 
                        'cal.read_only_option_id', 
                        'uc.member_type_id','cs.display_option_id',
                        'cal.hex_code']; 

            $query   = (new \yii\db\Query())
                    ->select($select)
                    ->from('calendar cal')
                    ->join('INNER JOIN','collection col' , 'cal.collection_id=col.id')
                    ->join('INNER JOIN','user_collection uc', 'uc.collection_id=col.id')
                    ->join('LEFT JOIN','calendar_subscription cs', 'cs.calendar_id=cal.id')
                    ->where('(uc.status_id=:status_active) 
                            AND 
                            (cal.status_id=:calendar_active)
                            AND 
                            (uc.expiry = 0 OR uc.expiry > UNIX_TIMESTAMP()) 
                            AND 
                            (uc.member_type_id=:mem_type_manager OR uc.member_type_id=:mem_type_member)
                            AND  
                            uc.user_id=:user_id')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                ':calendar_active'=>Types::$status['active']['id'], 
                                ':mem_type_manager'=>Types::$member_type['manager']['id'], 
                                ':mem_type_member'=>Types::$member_type['member']['id'], 
                                ':user_id'=>\Yii::$app->user->identity->id 
                        ])->all();

            
              

             return  $query; 
         

    }
    /* ******************************************************************************************************* */ 

}