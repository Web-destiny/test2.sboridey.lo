<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminLteAsset extends \dmstr\web\AdminLteAsset
{
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        // 'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];
}
