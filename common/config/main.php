<?php
$db = require __DIR__ . '/db.php';
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'jc-chat' => [
            'class' => 'common\modules\JcChat\JcChatModule',
        ],
    ],

    'components' => [
	 'authClientCollection' => [
      	  	'class' => 'yii\authclient\Collection',
        	'clients' => [
            		'google' => [
                		'class'        => 'yii\authclient\clients\Google',
                		'clientId'     => '269300118930-abg3316vc57i2ab4peleghjarhj96tnt.apps.googleusercontent.com',
                		'clientSecret' => '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',
                		'returnUrl'    => 'https://dev.mydesk.digital/NewWeclickUp/admin/site/auth-social?authclient=google',
                		'scope'        => 'email profile',
            		],
        	],
    	],
        'SystemNotifications' => [
            'class' => 'common\components\SystemNotifications',
        ],
        'AccessControl' => [
            'class' => 'common\components\MyAccessControl',
        ],
        'Emails' => [
            'class' => 'common\components\Emails',
        ],
        'SessionActivity' => [
            'class' => 'common\components\JcLocationLang\SessionActivity',
        ],
        'CountryCode' => [
            'class' => 'common\components\CountryCode',
        ],
        'Translate' => [
            'class' => 'common\components\JcAwsTranslate\JcAwsTranslate',
            'currentLanguage' => 'auto',
            'targetLanguage' => 'en'
        ],
        'LocationLang'=> [
            'class' => 'common\components\JcLocationLang\JcLocationLang',
            //'Akey' => 'be0f755b93290b4c100445d77533d291763a417c75524e95e07819ad'
            'Akey' =>'1e4f2663287d44fbdb57f0f5ec8e137b7aadef3b577aa7d216e9bd62'
        ],
        'ip2location' => [
            'class' => 'IP2LocationYii\IP2Location_Yii',
            'database' => '@app/../data-ip/IP2LOCATION-LITE-DB1.BIN', // Ruta al archivo BIN
            'mode' => 1, // o IP2Location::SHARED_MEMORY para mejor performance
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'transport' => [
                'scheme' => 'smtp',
                'host' => 'smtp-relay.brevo.com',
                'username' => '97aefc001@smtp-brevo.com',
                'password' => 'DNAbLYVyShTICfBZ',
                'port' => 587,
               // 'dsn' => 'native://default',
            ],

            // 'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => false,
            'messageClass' => 'yii\symfonymailer\Message'
        ],
        'mailerSes' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'transport' => [
                // 'scheme' => 'smtps',
                // 'host' => 'email-smtp.us-east-1.amazonaws.com',
                // // // 'username' => 'AKIAQPPXI3FRMMV37N6V',
                // // // 'password' => 'BFwwEUGNNPjFvGecfKz0pBfzZIHlQF91ehAY9T0gLvmy',
                // 'username' => 'AKIAQPPXI3FRHNUGVVVP',
                // 'password' => 'agiRnhl6Ym8Ul+pBvrD6rRkHHlXJ8ADCZSEumDql',
                // 'port' => 587,
                // 'encryption' => 'tls',
               // 'dsn' => 'native://default',
                'dsn' => 'ses+smtp://AKIAQPPXI3FRMMV37N6V:' . urlencode('BFwwEUGNNPjFvGecfKz0pBfzZIHlQF91ehAY9T0gLvmy') . '@default?region=us-east-1',
            
            ],

            // 'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => false,
            'messageClass' => 'yii\symfonymailer\Message'
        ],
        'mg' => [
            'class' => 'common\components\MailgunSender',
            'domain' => 'dev.mydesk.digital',
            'fromSender' => "WeclickDigital <no-reply@dev.mydesk.digital>",
            //'key' => '11c0a8f99a29789b0f81437d2db760a6-51afd2db-34978757',
            // 'key' => 'key-305f029576472da3cdcacfa2435c2aa5',
            'key' => '2280e27e111e0423d1a17b09aa1295a6-51afd2db-4a0c15fc',
	],
	'RecoverPass' => [
            'class' => 'common\components\RecoverPass\RecoverPass',

	],
	 'LocationLang'=> [
            'class' => 'common\components\JcLocationLang\JcLocationLang',
            //'Akey' => 'be0f755b93290b4c100445d77533d291763a417c75524e95e07819ad'
            'Akey' =>'1e4f2663287d44fbdb57f0f5ec8e137b7aadef3b577aa7d216e9bd62'
        ],

        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => [
                        '<controller:\w+>/<id:\d+>' => '<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    ],
        ],
        'urlManagerCpanel' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '../cpanel',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'db' => $db,
    ],
    'language'=>'es',
    'params' => [
        'ProyectName' => 'weclickdigital.com'
    ],
    'on beforeRequest' => function($event) {
        $infous = Yii::$app->LocationLang->infoSet();
        yii::$app->params['InfoLocation'] = $infous;         
    },
];
