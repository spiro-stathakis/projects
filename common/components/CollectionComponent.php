<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;


class CollectionComponent extends Object
{

	private $_collectionMembership; 
	private $_collectionUserData; 
	
	/* ******************************************************************************************************* */ 
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
    /* ******************************************************************************************************* */ 
    private function _getCollectionData()
    {
    		$this->_collectionMembership   = (new \yii\db\Query())
    				->select(['c.id as collection_id','c.title as title' , 'c.description',
    					'rct.name as collection_type_name',  
    					'rct.id as collection_type_id', 
    					'uc.member_type_id', 
    					'rmt.name as member_type_name', 
    					'uc.expiry'])
    				->from('collection c')
    				->join('INNER JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
    				->join('INNER JOIN','user_collection uc', 'uc.collection_id=c.id')
                    ->join('INNER JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
    				->where('uc.status_id=:status_active AND uc.user_id=:user_id AND (uc.expiry > UNIX_TIMESTAMP() OR uc.expiry=0) ')
    				->addParams([':status_active'=>Types::$status['active']['id'], 
    							 ':user_id'=>\Yii::$app->user->id 
    					])
    				->all();

            return $this->_collectionMembership ; 
    }
    /* ******************************************************************************************************* */ 
    public function init()
    {
        if ($this->_collectionMembership === null)
        {
                $this->_getCollectionData(); 
                
        }

        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    public function isManager($collection_id)
    {
        $return = false; 
        foreach($this->_collectionMembership as $collection)
            if ($collection['member_type_id'] == Types::$member_type['manager']['id'] && 
                $collection['collection_id'] == $collection_id 
            )
                $return = true; 
        
        return $return; 
    }
    /* ******************************************************************************************************* */ 
    public function ajaxCollectionMembers($collection_id)
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

    public function isMember($collection_id)
    {
        $return = false; 
        foreach($this->_collectionMembership as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'] && 
                $collection['collection_id'] == $collection_id 
            )
                $return = true; 
        
        return $return; 


    }
    /* ******************************************************************************************************* */ 
    
   
	
    /* ******************************************************************************************************* */ 
    public function getMyMemberList()
	{
        $return = [];
        foreach($this->_collectionMembership as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'])
                $return[] = $collection; 
        
        return $return; 

	}
	/* ******************************************************************************************************* */ 
    public function getMyList()
    {
        return $this->_collectionMembership; 
    }
    /* ******************************************************************************************************* */ 
    public function  getMyManagerList()
	{
        $return = [];
        foreach($this->_collectionMembership as $collection)
            if ($collection['member_type_id'] == Types::$member_type['manager']['id'])
                $return[] = $collection; 
        
        return $return; 


	}
	/* ******************************************************************************************************* */ 
    public function getCalendarCollections()
    {
        $return = [];
        foreach($this->_collectionMembership as $collection)
            if (
                $collection['member_type_id'] == Types::$member_type['manager']['id'] || 
                $collection['collection_type_id'] == Types::$collection_type['group']['id']
             )
                $return[] = $collection; 
        
        return $return; 
   
    }

}