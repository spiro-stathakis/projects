<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\packages;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppJsAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $css = [
    //'css/sb-admin.css'
    ];
    public $js = [
        'js/app/boot.js'
    ];
    public $depends = [
        'common\packages\MomentJsAsset',
        'yii\web\JqueryAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
}
