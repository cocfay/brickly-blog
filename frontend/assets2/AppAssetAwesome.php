<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAssetAwesome extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/regular.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/svg-with-js.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
