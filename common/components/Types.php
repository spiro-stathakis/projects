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
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    
	public static $sex = [
			'n'=>['id'=>1,'code'=>'n','name'=>'no value' , 'description'=>'No value'] ,
			'f'=>['id'=>2,'code'=>'m','name'=>'female' , 'description'=>'Female'] ,
			'm'=>['id'=>3,'code'=>'f','name'=>'male' , 'description'=>'Male'] ,
	]; 


}