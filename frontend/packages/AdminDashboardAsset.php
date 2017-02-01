<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class AdminDashboardAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $css = [
		
	]; 
	public $js = [
		'js/app/adminDashboard.js'
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'common\packages\AppJsAsset',
		'frontend\packages\BootstrapGrowlAsset',
	]; 


} 
