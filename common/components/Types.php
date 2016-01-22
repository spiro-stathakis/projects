<?php 
namespace common\components; 

class Types extends \common\components\XComponent
{


public static $status = [
			'null'=>['id'=>1,'code'=>'n','name'=>'no value' , 'description'=>'No value'] ,
			'active'=>['id'=>2,'code'=>'active','name'=>'Active' , 'description'=>'An active piece of information'] ,
			'inactive'=>['id'=>3,'code'=>'inactive','name'=>'Inactive' , 'description'=>'An inactive piece of information'] ,
	]; 

	/* ************************************************************************************************************************* */ 
    
	public static $boolean = [
			'null'=>['id'=>1,'code'=>'n','name'=>'no value' , 'description'=>'No value'] ,
			'true'=>['id'=>2,'code'=>'true','name'=>'True' , 'description'=>'Truthy'] ,
			'false'=>['id'=>3,'code'=>'false','name'=>'False' , 'description'=>'Falsey'] ,
	]; 

	/* ************************************************************************************************************************* */ 
	public static $auth_type = [
			'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'ldap'=>['id'=>2,'code'=>'ldap','name'=>'LDAP' , 'description'=>'LDAP authentication'] ,
			'db'=>['id'=>3,'code'=>'db','name'=>'Datbase' , 'description'=>'Database authentication'] ,
	]; 


    /* ************************************************************************************************************************* */ 
	public static $member_type = [
			'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'member'=>['id'=>2,'code'=>'member','name'=>'Member' , 'description'=>'Membership of a collection'] ,
			'manager'=>['id'=>3,'code'=>'manager','name'=>'Manager' , 'description'=>'Manager of a collection'] ,
	]; 
    

    /* ************************************************************************************************************************* */ 
    public static $collection_type = [
			'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'training'=>['id'=>2,'code'=>'training','name'=>'Training' , 'description'=>'A training based collection'] ,
			
	]; 


    /* ************************************************************************************************************************* */ 
	public static $input_type = [
			'null'=>['id'=>1,'code'=>'null','name'=>'no value' , 'description'=>'No value'] ,
			'small_text'=>['id'=>2,'code'=>'small_text','name'=>'Small text' , 'description'=>'Small text field'] ,
			'med_text'=>['id'=>2,'code'=>'med_text','name'=>'Medium text' , 'description'=>'Medium text field'] ,
			'large_text'=>['id'=>2,'code'=>'large_text','name'=>'Large text' , 'description'=>'Large text field'] ,
			'date'=>['id'=>2,'code'=>'date','name'=>'Date' , 'description'=>'Date field'] ,
			'radio'=>['id'=>2,'code'=>'radio','name'=>'Radio field' , 'description'=>'Radio field'] ,
			'text_agreement'=>['id'=>2,'code'=>'text_agreement','name'=>'Text agreement' , 'description'=>'Text agreement field'] ,
			'file'=>['id'=>2,'code'=>'file','name'=>'File upload' , 'description'=>'File upload'] ,
			
	]; 

    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    
	public static $sex = [
			'n'=>['id'=>1,'code'=>'n','name'=>'no value' , 'description'=>'No value'] ,
			'f'=>['id'=>2,'code'=>'m','name'=>'female' , 'description'=>'Female'] ,
			'm'=>['id'=>3,'code'=>'f','name'=>'male' , 'description'=>'Male'] ,
	]; 


}