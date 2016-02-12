<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;
use common\components\Types; 
use yii\bootstrap\Html;


class ProjectComponent extends Object
{

	private $_myProjects; 
    private $_allProjects;  
	private $_userId; 
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    public function init()
    {
        if (! yii::$app->user->isGuest)
            $this->_userId = yii::$app->user->id; 

        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    public function getMyProjects()
	{
        $arr = [ Types::$member_type['manager']['id']=>[],
                    Types::$member_type['member']['id']=>[],
                    Types::$member_type['collab']['id']=>[], 
                    Types::$member_type['assoc']['id']=>[], 
                ]; 
        if ($this->_myProjects === null)
                $this->_myProjects = $this->_myProjects(); 
        
        foreach ($this->_myProjects as $row)
            $arr[ $row['member_type_id'] ][] = $row;  
        

        return $arr; 


	}
	/* ******************************************************************************************************* */ 
    public function isMember($project_id)
    {

        $return  = false; 
        foreach($this->myProjects[Types::$member_type['member']['id']] as $project)
            if ( $project['project_id'] == $project_id) 
                $return = true; 

        return true; 

    }
    /* ******************************************************************************************************* */ 
    public function getAllProjects()
    {
        if ($this->_allProjects === null)
            $this->_allProjects =  $this->_allProjects(); 

        return $this->_allProjects; 
    }
    /* ******************************************************************************************************* */ 
    /* private functions */ 
    /* ******************************************************************************************************* */ 
   /* ******************************************************************************************************* */ 
   
   private  function _allProjects() 
    {

            return (new \yii\db\Query())
                    ->select([
                            'c.title as collection_title','c.description as collection_description',
                            'p.id as project_id','p.title as project_title','p.code as project_code'
                           ])
                    ->from('collection c')
                    ->join('LEFT JOIN','project_collection pc' , 'pc.collection_id=c.id')
                    ->join('LEFT JOIN','project p' , 'pc.project_id=p.id')
                    ->orderBy('p.created_at DESC')
                    ->all();

         

    }
   /* ******************************************************************************************************* */ 
     private  function _myProjects() 
    {

            return (new \yii\db\Query())
                    ->select([
                            'c.title as collection_title','c.description as collection_description',
                            'p.id as project_id','p.title as project_title','p.code as project_code', 
                            'uc.member_type_id'
                             ])
                    ->from('collection c')
                    ->join('LEFT JOIN','project_collection pc' , 'pc.collection_id=c.id')
                    ->join('LEFT JOIN','project p' , 'pc.project_id=p.id')
                    ->join('LEFT JOIN','user_collection uc' , 'uc.collection_id=c.id')
                    ->where('uc.status_id=:status_active AND uc.user_id=:user_id')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':user_id'=>$this->_userId 
                        ])
                    ->all();

         

    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    

}