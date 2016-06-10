<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class BootstrapPopoverAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $css = [
	]; 
	public $js = [
		'js/app/bootstrap-popover.js'
	]; 
	public $depends =[
		'frontend\packages\BootstrapTooltipAsset',
	]; 


} 
