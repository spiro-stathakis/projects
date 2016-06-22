<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;
use common\components\Types; 
/* 
Function: 

isManager: Returns boolean 
isMember:  Returns boolean 
getEvents: Get events appropriate to user context 
getMyCalendarList: Return array ['id'=>'name'] of items that is appropriate to user context AND selected to view
getTheCalendarList: Return array ['id'=>'name'] of items that is appropriate to user context 
getMyCalendars: Return array of records that is appropriate to user context 
hasConflict: Returns boolean 
calendarRecord: Retrieves a single calendar record 
*/ 
class CalendarComponent extends Object
{

	

    private $_myCalendars; 
    private $_myCalendarList; 
    private $_theCalendarList; 
    private $_allCalendars; 
    
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    
    public function init()
    {
      
        return parent::init(); 
    }
    
    /* ******************************************************************************************************* */ 
    public function canCreateEvent($calendar_id)
    {
        
        if ($this->isMember($calendar_id))
            return true; 
        if ($this->isManager($calendar_id))
            return true; 
        

        return false; 
    }
    
    /* ******************************************************************************************************* */ 
    
    public function canUpdateEvent($event)
    {
        if ($this->isReadOnly($event['calendar_id']))
            return false; 

        if ($this->isManager($event['calendar_id']))
            return true; 
        if ($event['created_by'] == yii::$app->user->id)
            return true; 

        return false; 
    }
    
    /* ******************************************************************************************************* */ 
    public function isReadOnly($calendar_id)
    {
        $return = false; 
        foreach($this->allCalendars as $rec)
            if ($rec['read_only_option_id'] == Types::$boolean['true']['id']) 
                $return = true; 
        
        return $return; 
    }
    
    /* ******************************************************************************************************* */ 
    
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
    public function hasConflict($start,$end,$calendar_id,$event_entry_id = null)
    {
        $rec =  $this->_hasConflict($start,$end,$calendar_id); 
        if (count($rec) == 0 ) 
            return false; 
        if ($event_entry_id !== null) 
            if ($rec[0]['event_entry_id'] == $event_entry_id) 
                return false; 

        return true; 


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
    public function getManagementList()
    {
        $out = []; 
        foreach($this->myCalendars as $cal)
            if ($cal['member_type_id'] == Types::$member_type['manager']['id'])
                $out[$cal['calendar_id']] = $cal['calendar_title']; 

        return $out; 

    }
    /* ******************************************************************************************************* */ 
    
    public function  getMyCalendars()
	{

        if ($this->_myCalendars == null) 
            $this->_myCalendars = $this->_getMyCalendars(); 

        return $this->_myCalendars; 
    }
	
    /* ******************************************************************************************************* */ 
    
    public function calendarRecord($calendar_id)
    {
        $rec = false; 
        foreach($this->theCalendarList as $cal)
            if ($cal['calendar_id'] == $calendar_id )
                $rec = $cal; 
        return $rec; 

    }     

    /* ******************************************************************************************************* */ 
    
    public function allowOverlapOption($calendar_id)
    {
       $out = false; 
        foreach($this->myCalendars as $cal)
            if ($cal['calendar_id'] == $calendar_id)
                if ($cal['allow_overlap_option_id'] == Types::$boolean['true']['id'])
                    $out = true;
        return $out;  
   
    }
    /* ******************************************************************************************************* */ 
    public function getAllCalendars()
    {

        if ($this->_allCalendars == null)
             $this->_allCalendars = $this->_getAllCalendars(); 

         return $this->_allCalendars; 
    }
    /* ******************************************************************************************************* */ 
    public function eventEntryRecord($event_entry_id)
    {
        return $this->_eventEntryRecord($event_entry_id);
    }
    /* ******************************************************************************************************* */ 
    public function projectOption($calendar_id)
    {
        $out = false; 
        foreach($this->myCalendars as $cal)
            if ($cal['calendar_id'] == $calendar_id)
                if ($cal['project_option_id'] == Types::$boolean['true']['id'])
                    $out = true;
        return $out;  

    }


    /* ******************************************************************************************************* */ 
    
    /*                                          PRIVATE FUNCTIONS                                              */ 

    /* ******************************************************************************************************* */ 
    private function _hasConflict($start, $end,$calendar_id)
         {
            $data   = (new \yii\db\Query())
                ->select(['e.id as event_id' , 'ee.id as event_entry_id' , 'ee.booking_status_id', 'c.id as calendar_id'])
                ->from('event e')
                ->join('INNER JOIN','calendar c' , 'e.calendar_id=c.id')
                ->join('INNER JOIN', 'event_entry ee' , 'ee.event_id=e.id')
                ->where(
                        '(c.id = :calendar_id AND ee.status_id=:event_entry_status_active)
                         AND 
                        (
                            ( :start >  ee.start_timestamp AND :start < ee.end_timestamp ) 
                            OR 
                            ( :end > ee.start_timestamp  AND  :end < ee.end_timestamp )
                            OR 
                            ( :start = ee.start_timestamp )
                            OR 
                            ( :start < ee.start_timestamp AND :end > ee.end_timestamp ) 
                             
                        )')
                 ->addParams([':start'=>$start, 
                             ':end'=>$end , 
                             ':calendar_id'=>$calendar_id , 
                             ':event_entry_status_active'=>Types::$boolean['true']['id']
                        ])
                ->all();

         return  $data; 

        }
    /* ******************************************************************************************************* */ 
     private function _eventEntryRecord($event_entry_id)
         {
            $data   = (new \yii\db\Query())
                ->select([
                    'e.id as event_id' , 'ee.title',
                    'e.description as event_description' , 'e.calendar_id', 
                    'e.project_id' , 'IFNULL(col.title," No project ") as project_collection_title', 
                    'ee.id as event_entry_id' , 'ee.title as event_entry_title', 
                    'ee.description as event_entry_description', 'ee.booking_status_id', 
                    'ee.start_timestamp' , 'ee.end_timestamp' , 'ee.all_day_option_id' , 
                    'c.title as calendar_title', 
                    'c.hex_code','e.created_by', 'e.created_at',
                    'concat(u.first_name," " , u.last_name) as create_name' 
                    ])
                ->from('event e')
                ->join('LEFT JOIN','calendar c' , 'e.calendar_id=c.id')
                ->join('LEFT JOIN', 'event_entry ee' , 'ee.event_id=e.id')
                ->join('LEFT JOIN','ref_booking_status rbs', 'ee.booking_status_id=rbs.id')
                ->join('LEFT JOIN', 'calendar_subscription cs' , 'cs.calendar_id=c.id')
                ->join('LEFT JOIN' , 'project p', 'p.id=e.project_id')
                ->join('LEFT JOIN' , 'collection col' , 'c.id=p.collection_id')
                ->join('LEFT JOIN' , 'user u', 'u.id=e.created_by')
                ->where('ee.id = :event_entry_id')
                 ->addParams([':event_entry_id'=>$event_entry_id])
                ->one();

         return  $data; 

        }
    /* ******************************************************************************************************* */ 
    
    private function _getEvents($start, $end)
         {
            $data   = (new \yii\db\Query())
                ->select([
                    'e.id as event_id' , 'e.title as event_title',
                    'e.description as event_description' , 'e.calendar_id', 
                    'e.project_id' , 'IFNULL(col.title," No project ") as project_collection_title', 
                    'ee.id as event_entry_id' , 'ee.title as event_entry_title', 
                    'ee.description as event_entry_description', 'ee.booking_status_id', 
                    'ee.start_timestamp' , 'ee.end_timestamp' , 'ee.all_day_option_id' , 
                    'c.title as calendar_title', 
                    'c.hex_code','e.created_by', 'e.created_at',
                    'concat(u.first_name," " , u.last_name) as create_name' 
                    ])
                ->from('event e')
                ->join('LEFT JOIN','calendar c' , 'e.calendar_id=c.id')
                ->join('LEFT JOIN', 'event_entry ee' , 'ee.event_id=e.id')
                ->join('LEFT JOIN','ref_booking_status rbs', 'ee.booking_status_id=rbs.id')
                ->join('LEFT JOIN', 'calendar_subscription cs' , 'cs.calendar_id=c.id')
                ->join('LEFT JOIN' , 'project p', 'p.id=e.project_id')
                ->join('LEFT JOIN' , 'collection col' , 'c.id=p.collection_id')
                ->join('LEFT JOIN' , 'user u', 'u.id=e.created_by')
                ->where(
                        '(ee.start_timestamp >= :start AND ee.end_timestamp <= :end)
                            AND 
                        (cs.display_option_id = :true OR cs.display_option_id IS NULL)
                            AND
                         ee.status_id=:event_entry_status_active'
                        )
                 ->addParams([':start'=>$start, 
                             ':end'=>$end , 
                             ':true'=>Types::$boolean['true']['id'], 
                             ':event_entry_status_active'=>Types::$status['active']['id'],  
                        ])
                ->all();

         return  $data; 

        }
    /* ******************************************************************************************************* */ 
   private function _getAllCalendars()
   {

            $select =  ['cal.id as calendar_id', 'cal.collection_id', 
            'cal.title as calendar_title',
            'col.title  as collection_title',
            'cal.project_option_id', 
            'cal.allow_overlap_option_id', 
            'cal.read_only_option_id', 
            'cal.hex_code']; 
            $query   = (new \yii\db\Query())
                    ->select($select)
                    ->from('calendar cal')
                    ->join('INNER JOIN','collection col' , 'cal.collection_id=col.id')
                   
                    ->where('(cal.status_id=:calendar_active)')
                    ->addParams([':calendar_active'=>Types::$status['active']['id']])
                    ->all();
            return  $query; 
    }
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    private function _getMyCalendars()
    {

            $select =  ['cal.id as calendar_id', 'cal.collection_id', 
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