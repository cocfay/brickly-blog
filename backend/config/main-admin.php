<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
   // require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
   // require __DIR__ . '/test.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\UserAccount',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-session',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../../admin/assets',
        ],
        'request' => [
            'cookieValidationKey' => 'AdvanceCookieBackEnd',
        ],
    ],
    'params' => $params,
    'defaultRoute' => 'site/admin-login',
    'on beforeRequest' => function($event) {
        $infous = Yii::$app->LocationLang->infoSet();
        yii::$app->params['InfoLocation'] = $infous;  
            
        $stringWeb = \Yii::getAlias('@web');
        $stringWebRoot = \Yii::getAlias('@webroot');
        $stringWeb = str_replace(["/admin/","/admin"],'',$stringWeb);
        $stringWebRoot = str_replace(["/admin/","/admin"],'',$stringWebRoot);
	if($stringWeb == "" || $stringWeb == "/"){ $stringWeb = "/."; }
        yii::setAlias('@proyectroot', $stringWebRoot);        
        yii::setAlias('@raizweb',$stringWeb);
        
        
    }
];
