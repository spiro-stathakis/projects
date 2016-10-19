
<?php use yii\helpers\Json; ?> 
<?php use \common\components\LdapComponent;?> 
<?php 






$curl = Yii::$app->CurlComponent; 

$curl->useAuth(true); 
$curl->createCurl('http://l001.cubric.cf.ac.uk:8042/patients');
$data = Json::decode($curl->toString());

print_r($data); 
 
$count =0 ; 
foreach ($data as $s)
{
	
	if ($count == 0)
	{
		$curl->createCurl('http://l001.cubric.cf.ac.uk:8042/patients/' . $s);
		echo 'http://l001.cubric.cf.ac.uk:8042/patients/' . $s; 
		$row  = Json::decode($curl->toString());
		foreach ($row as $r)
			print_r($r);
			echo "<br />"; 
	}	

	$count++;
} 
	
 


