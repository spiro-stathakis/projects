<?php 
namespace common\components; 

class Types extends \common\components\XComponent
{


public static $status = [
			'null'=>['id'=>1,'code'=>'n','name'=>'no value' , 'description'=>'No value'] ,
			'active'=>['id'=>2,'code'=>'active','name'=>'Active' , 'description'=>'An active piece of information'] ,
			'inactive'=>['id'=>3,'code'=>'inactive','name'=>'Inactive' , 'description'=>'An inactive piece of information'] ,
	]; 

	/* ******************************************************************************************** */ 
	public static $boolean = [
			'null'=>['id'=>1,'code'=>'n','name'=>'no value' , 'description'=>'No value'] ,
			'true'=>['id'=>2,'code'=>'true','name'=>'True' , 'description'=>'Yes'] ,
			'false'=>['id'=>3,'code'=>'false','name'=>'False' , 'description'=>'No'] ,
	]; 

	/* ******************************************************************************************** */ 
	public static $auth_type = [
			'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'ldap'=>['id'=>2,'code'=>'ldap','name'=>'LDAP' , 'description'=>'LDAP authentication'] ,
			'db'=>['id'=>3,'code'=>'db','name'=>'Datbase' , 'description'=>'Database authentication'] ,
	]; 


    /* ******************************************************************************************** */ 
	public static $member_type = [
			'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'manager'=>['id'=>2,'code'=>'manager','name'=>'Manager' , 'description'=>'Manager of a collection'] ,
			'member'=>['id'=>3,'code'=>'member','name'=>'Member' , 'description'=>'Membership of a collection'] ,
			'collab'=>['id'=>4,'code'=>'collab','name'=>'Collaborator' , 'description'=>'Collaborator of a collection'] ,
			'assoc'=>['id'=>5,'code'=>'assoc','name'=>'Associate' , 'description'=>'Associate of a collection'] ,
	]; 
    

    /* ******************************************************************************************************************** */ 
    public static $collection_type = [
			'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'resource'=>['id'=>2,'code'=>'resource','name'=>'Resource' , 'description'=>'A collection for a resource at CUBRIC (ie. a scanner)'] ,
			'project'=>['id'=>3,'code'=>'project','name'=>'Project' , 'description'=>'A collection for a project at CUBRIC (ie. a researcher study)'] ,
			'group'=>['id'=>4,'code'=>'group','name'=>'Group' , 'description'=>'A collection for a group at CUBRIC (ie. an ldap group)'] ,
					
	]; 


    /* ******************************************************************************************** */ 
	public static $input_type = [
			'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'small_text'=>['id'=>2,'code'=>'small_text','name'=>'Small text' , 'description'=>'Small text field'] ,
			'med_text'=>['id'=>3,'code'=>'med_text','name'=>'Medium text' , 'description'=>'Medium text field'] ,
			'large_text'=>['id'=>4,'code'=>'large_text','name'=>'Large text' , 'description'=>'Large text field'] ,
			'date'=>['id'=>5,'code'=>'date','name'=>'Date' , 'description'=>'Date field'] ,
			'radio'=>['id'=>6,'code'=>'radio','name'=>'Radio field' , 'description'=>'Radio field'] ,
			'text_agreement'=>['id'=>7,'code'=>'text_agreement','name'=>'Text agreement' , 'description'=>'Text agreement field'] ,
			'image_overlay'=>['id'=>8,'code'=>'image_overlay','name'=>'Image overlay' , 'description'=>'File upload'] ,
			'text_area'=>['id'=>9,'code'=>'text_area','name'=>'Text area' , 'description'=>'Text area'] ,
			
	]; 

    /* ******************************************************************************************** */ 
    public static $progress = [
    		'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'in_progress'=>['id'=>2,'code'=>'in_progress','name'=>'In progress' , 'description'=>'Small text field'] ,
			'published'=>['id'=>3,'code'=>'published','name'=>'Published' , 'description'=>'Published'] ,
			
    ];
    
	/* ******************************************************************************************** */ 
	public static $systemEvent = [
		'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
		'user_activated'=>['id'=>2,'code'=>'user_activated','name'=>'User activated','description'=>'User activated'],
		'user_deactivated'=>['id'=>3,'code'=>'user_deactivated','name'=>'User deactivated','description'=>'User deactivated'],
			
	];
	/* ******************************************************************************************** */ 
/* ******************************************************************************************** */ 
/* ******************************************************************************************** */ 
/* ******************************************************************************************** */ 


    public static $bookingStatus = [
    		'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'pending'=>['id'=>2,'code'=>'pending','name'=>'Pending' , 'description'=>'Pending'] ,
			'confirmed'=>['id'=>3,'code'=>'confirmed','name'=>'Confirmed' , 'description'=>'Confirmed'] ,
			'cancelled'=>['id'=>4,'code'=>'cancelled','name'=>'Cancelled' , 'description'=>'Cancelled'] ,
			'conflict'=>['id'=>4,'code'=>'conflict','name'=>'Conflict' , 'description'=>'Conflict'] ,
			'denied'=>['id'=>4,'code'=>'denied','name'=>'Denied' , 'description'=>'Denied'] ,


			
    ];
    /* ****************************************************************************************************************** */ 
    /* ******************************************************************************************************************* */ 
    
	public static $sex = [
			'n'=>['id'=>1,'code'=>'n','name'=>'no value' , 'description'=>'No value'] ,
			'f'=>['id'=>2,'code'=>'m','name'=>'female' , 'description'=>'Female'] ,
			'm'=>['id'=>3,'code'=>'f','name'=>'male' , 'description'=>'Male'] ,
	]; 


}