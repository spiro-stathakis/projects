<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;


class CollectionComponent extends Object
{

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
	private $_collectionMembership; 
	private $_collectionUserData; 
    private $_theCollections; 
    private $_theCollectionList; 
    private $_thePublicCollections; 

	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    public function init()
    {
        
                
        if (yii::$app->user->isGuest)
             throw new \yii\web\HttpException(500, sprintf('Not available to guest users'));

        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    public function isManager($collection_id)
    {
        $return = false; 
        foreach($this->theCollections as $collection)
            if ($collection['member_type_id'] == Types::$member_type['manager']['id'] && 
                $collection['collection_id'] == $collection_id 
            )
                $return = true; 
        
        return $return; 
    }
    /* ******************************************************************************************************* */ 
    public function isMember($collection_id)
    {
        $return = false; 
        foreach($this->theCollections as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'] && 
                $collection['collection_id'] == $collection_id 
            )
                $return = true; 
        
        return $return; 


    }
    /* ******************************************************************************************************* */ 
    public function getTheCollections()
    {
        if ($this->_theCollections === null)
            $this->_theCollections = $this->_getTheCollections();
        if ($this->_thePublicCollections === null)
        {
            $this->_thePublicCollections = $this->_getThePublicCollections(); 
            foreach ($this->_thePublicCollections as $col)
            {
                 $col['member_type_id'] = Types::$member_type['member']['id']; 
                 $this->_theCollections[] = $col;  
            }
        
        }

        return $this->_theCollections; 
    }
    /* ******************************************************************************************************* */ 
    public function memberList($collection_id)
    {
        
        $out = array(); 
        $data = $this->_getCollectionUsers($collection_id); 
        if ($data)
            foreach ( $data as $c)
                if ($c['member_type_id']  == Types::$member_type['member']['id'])
                        $out[$c['user_id']]  = sprintf('%s %s (%s)', $c['first_name'] , $c['last_name'] , $c['user_name']); 
                   
        return $out; 

    }

    
    /* ******************************************************************************************************* */ 
    

     public function  getMyManagerCollections()
    {
        $out = [];
        foreach($this->theCollections as $collection)
            if ($collection['member_type_id'] == Types::$member_type['manager']['id'])
                $out[] = $collection; 
        
        return $out; 


    }
	
    /* ******************************************************************************************************* */ 
    public function getMyMemberCollections()
	{
        $out = [];
        foreach($this->theCollections as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'])
                $out[] = $collection; 
        
        return $out; 

	}
	/* ******************************************************************************************************* */ 
    public function getMyManagerList()
    {
        $out = []; 
        foreach($this->myManagerCollections as $collection)
            $out[$collection['collection_id']] = $collection['collection_title']; 
        
        return $out; 
    }
    /* ******************************************************************************************************* */ 
    public function getMyMemberList()
    {
        $out = []; 
        foreach($this->myMemberCollections as $collection)
            $out[$collection['collection_id']] = $collection['collection_title']; 
        
        return $out; 
    }

	/* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    private function _getCollectionUsers($collection_id)
    {
            $this->_collectionUserData   = (new \yii\db\Query())
                    ->select(['u.first_name' , 'u.last_name', 'u.user_name','u.id as user_id', 
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id', 
                        'uc.member_type_id', 
                        'rmt.name as member_type_name', 
                        'uc.expiry'])
                    ->from('user_collection uc')
                    ->join('INNER JOIN','collection c' , 'c.id=uc.collection_id') 
                    ->join('INNER JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->join('INNER JOIN','user u', 'uc.user_id=u.id')
                    ->join('INNER JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
                    ->where('uc.status_id=:status_active AND uc.collection_id=:collection_id AND (uc.expiry > UNIX_TIMESTAMP() OR uc.expiry=0) ')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':collection_id'=>$collection_id 
                        ])
                     ->orderBy('u.first_name', 'u.last_name')
                    ->all();

        return $this->_collectionUserData  ; 
    }
    /* ******************************************************************************************************* */
    private function _getThePublicCollections()
    {
         return  (new \yii\db\Query())
                    ->select(['c.id as collection_id','c.title as collection_title' , 'c.description as collection_description',
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id'])
                    ->from('collection c')
                    ->join('INNER JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->where('c.public_option_id=:boolean_true AND c.status_id=:status_active')
                    ->addParams([
                            ':status_active'=>Types::$status['active']['id'],
                            ':boolean_true'=>Types::$boolean['true']['id'], 
                     ])
                    ->all();
    }
    /* ******************************************************************************************************* */ 
    private function _getTheCollections()
    {
           return  (new \yii\db\Query())
                    ->select(['c.id as collection_id','c.title as collection_title' , 'c.description as collection_description',
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id', 
                        'uc.member_type_id', 
                        'rmt.name as member_type_name', 
                        'uc.expiry'])
                    ->from('collection c')
                    ->join('INNER JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->join('INNER JOIN','user_collection uc', 'uc.collection_id=c.id')
                    ->join('INNER JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
                    ->where('(uc.status_id=:status_active AND uc.user_id=:user_id AND (uc.expiry > UNIX_TIMESTAMP() OR uc.expiry=0)) ')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':user_id'=>\Yii::$app->user->id , 
                                 
                        ])
                    ->all();

           
    }
    

}