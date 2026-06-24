<?php
/**
 * @copyright Copyright (c) 2023 JcFariasC RecoverPass
 * @version 1.0.1
 */
namespace common\components\RecoverPass;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class RecoverPassAsset extends AssetBundle
{
     public $sourcePath = '@common/components/RecoverPass/assets/';
    public $css = [
        'css/login.css',
        'css/animate.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css',
        'css/Style.css'

    ];
    public $js = [
        'js/login.js',
        'js/notify.js',
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}

