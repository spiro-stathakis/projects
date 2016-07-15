<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class BootstrapTooltipAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $css = [
	]; 
	public $js = [
		'js/app/bootstrap-tooltip.js'
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'common\packages\AppJsAsset',
	]; 


} 
