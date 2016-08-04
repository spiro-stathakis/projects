
<?php use yii\helpers\Json; ?> 
<?php use \common\components\LdapComponent;?> 
<?php 

yii::$app->UserComponent->import(); 



/*
$curl = Yii::$app->CurlComponent; 

$curl->useAuth(true); 
$curl->createCurl('http://l001.cubric.cf.ac.uk:8042/studies');
$data = Json::decode($curl->toString());

 
$count =0 ; 
foreach ($data as $s)
{
	
	if ($count == 0)
	{
		$curl->createCurl('http://l001.cubric.cf.ac.uk:8042/studies/' . $s);
		echo 'http://l001.cubric.cf.ac.uk:8042/studies/' . $s; 
		$row  = Json::decode($curl->toString());
		foreach ($row as $r)
			print_r($r);
	}	

	$count++;
} 
	
 

*/
