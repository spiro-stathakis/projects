<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;


class ScreeningFormComponent extends Object
{

	public $screening_form_id; 
    public $project_id; 

    private $_myScreeningForms; 
    private $_allScreeningForms; 
    
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    public function init()
    {
      
        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    public function isManager($screening_form_id)
    {
        $return = false; 
        foreach($this->myScreeningForms as $collection)
            if ($collection['member_type_id'] == Types::$member_type['manager']['id'] && 
                $collection['screening_form_id'] == $screening_form_id 
            )
                $return = true; 
        
        return $return; 
    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    public function isMember($collection_id)
    {
        $return = false; 
        foreach($this->myScreeningForms  as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'] && 
                $collection['collection_id'] == $collection_id 
            )
                $return = true; 
        
        return $return; 


    }
    /* ******************************************************************************************************* */ 
    
    
	
    /* ******************************************************************************************************* */ 
    public function getAllScreeningForms()
	{
         if ($this->_allScreeningForms == null) 
            $this->_allScreeningForms = $this->_allMyScreeningForms(); 

        return $this->_allScreeningForms; 

	}
	/* ******************************************************************************************************* */ 
    public function  getMyScreeningForms()
	{

        if ($this->_myScreeningForms == null) 
            $this->_myScreeningForms = $this->_getMyScreeningForms(); 

        return $this->_myScreeningForms; 
    }
	/* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    private function _getAllScreeningForms()
    {
            $this->_allScreeningForms   = (new \yii\db\Query())
                    ->select([
                        's.id as screening_form_id' , 's.title as screening_form_title', 
                        's.title as screening_form_title' , 's.description as screening_form_description',
                        'c.id as collection_id','c.title as collection_title' , 'c.description as collection_description',
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id', 
                        'rmt.name as member_type_name'])
                    ->from('screening_form s')
                    ->join('LEFT JOIN','collection c' , 's.collection_id=c.id')
                    ->join('LEFT JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->join('LEFT JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
                    ->all();

         return  $this->_allScreeningForms ; 

    }
    /* ******************************************************************************************************* */ 
    private function _getMyScreeningForms()
    {
            $this->_myScreeningForms   = (new \yii\db\Query())
                    ->select([
                        's.id as screening_form_id' , 
                        's.title as screening_form_title' , 's.description as screening_form_description',
                        'c.id as collection_id','c.title as collection_title' , 'c.description as collection_description',
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id', 
                        'uc.member_type_id', 
                        'rmt.name as member_type_name', 
                        'uc.expiry'])
                    ->from('screening_form s')
                    ->join('LEFT JOIN','collection c' , 's.collection_id=c.id')
                    ->join('LEFT JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->join('LEFT JOIN','user_collection uc', 'uc.collection_id=c.id')
                    ->join('LEFT JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
                    ->where('uc.status_id=:status_active AND uc.user_id=:user_id AND uc.expiry > UNIX_TIMESTAMP()')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':user_id'=>\Yii::$app->user->identity->id 
                        ])
                    ->all();
             return  $this->_myScreeningForms ; 
         

    }
    /* ******************************************************************************************************* */ 

}