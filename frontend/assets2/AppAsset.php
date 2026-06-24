<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // CDN de Bootstrap 5
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        // CDN de FontAwesome 6
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css',
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css',
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css',
        'css/header.css',
        'css/pageSearch.css',
        'css/footer.css'
    ];
    public $js = [
        // CDN de Bootstrap 5 JS con dependencia de Popper.js
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}

