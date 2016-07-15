<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class AdminAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $css = [
		
	]; 
	public $js = [
		'js/app/admin.js'
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'common\packages\AppJsAsset',
		'frontend\packages\BootstrapGrowlAsset',
	]; 


} 
