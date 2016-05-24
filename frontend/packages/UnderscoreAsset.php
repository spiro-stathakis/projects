<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class UnderscoreAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    	public $baseUrl = '@web';
	public $css = [
		
	]; 
	public $js = [
		'js/app/underscore.js',
		
	]; 
	public $depends =[
		
	]; 


} 
