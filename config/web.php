<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log']  ,
	'components' => [
	'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '123456',
            'enableCsrfValidation' => 'true',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // 一定不要发布该资源
                    'js' => [
                    ]
                ],
            ],
        ],
     'response'=>[
         'format' => yii\web\Response::FORMAT_HTML,
         'charset' => 'UTF-8',
     ],
	    'urlManager'=>[
	        'enablePrettyUrl' => true,
            'enableStrictParsing' =>false,
            'showScriptName' => false,
            'suffix'=> '.html',
            'rules' => [
                'info'=>'info/index',
                'articles'=>'article/index',
                'article/<id:\d+>' =>'article/detail',
                'article/edit/<article_id:\d+>' =>'article/edit',
		'articles/<find:\w+>' => 'article/search',


            ],
        ],
        'redis'=>[
            'class'=>'yii\redis\Connection',
            'hostname'=> 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'authManager' => [
            'class'=> 'yii\rbac\PhpManager',
            'defaultRoles' =>['author'],
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis'=>[
                'hostname'=> 'localhost',
                'port'=> 6379,
                'database' => 0,
            ],
        ],
//        'cache'=>[
//            'class'=> 'yii\caching\FileCache'
//        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath'=>'@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport'=> [
                'class'=>'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => '15683819149@163.com',
                'password'=>'mz456321',
                'port' => '25',
                'encryption' =>'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from' =>['15683819149@163.com'=>'詹洪'],
            ],
        ],
        'log' => [
            'flushInterval'=>'1',
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','profile'],
                    'exportInterval' => 1,
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        /*'urlManager' => [
            'enablePrettyUrl' => true,

            'rules' => [
            ],
        ],*/

    ],
'modules' => [ 
    'redactor' => [ 
        'class' => 'yii\redactor\RedactorModule', 
        'imageAllowExtensions'=>['jpg','png','gif'] 
    ], 
],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
