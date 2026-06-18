<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
   // require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
   // require __DIR__ . '/test.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\UserAccount',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-sess',
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
            'basePath' => __DIR__ . '/../../assets',
        ],
        'request' => [
            'cookieValidationKey' => 'AdvanceCookieEnd',
        ],
    ],
    'params' => $params,
    'defaultRoute' => 'blog',
    'on beforeRequest' => function($event) {
        $infous = Yii::$app->LocationLang->infoSet();
        yii::$app->params['InfoLocation'] = $infous;  
        yii::setAlias('@proyectroot', '@webroot');        
        yii::setAlias('@raizweb', '@web');        
    }
];
