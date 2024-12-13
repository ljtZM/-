<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5XGMxIAL5IX9xS0emFdBn7RCrnccKQpI',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'api/adminlogin' => 'api/adminlogin',

                'api/login' => 'api/authenticate',
                'api/signup' => 'api/register',

                'api/getarticle' => 'api/getarticle',
                'api/getarticlepagecount' => 'api/getarticlepagecount',
                'api/getarticlecomment' => 'api/getarticlecomment',
                'api/addarticlecomment' => 'api/addarticlecomment',
                'api/getarticlelikes' => 'api/getarticlelikes',
                'api/addarticlelikes' => 'api/addarticlelikes',

                'api/addwebviews' => 'api/addwebviews',
                'api/checkwebviews' => 'api/checkwebviews',
                
                'api/getvideo' => 'api/getvideo',
                'api/getvideocomments' => 'api/getvideocomments',
                'api/addvideocomments' => 'api/addvideocomments',
                'api/getvideolikes' => 'api/getvideolikes',
                'api/addvideolikes' => 'api/addvideolikes',

                'api/getclick' => 'api/getclick',
                'api/addclick' => 'api/addclick',

                'api/getpersonalinfo' => 'api/getpersonalinfo',
                
                'Users/index' => 'users/index',
                'article/index' => 'article/index',
                'articlecomments/index' => 'articlecomments/index',
                'articlelikes/index' => 'articlelikes/index',
            ],
        ],  
    ],
    'as corsFilter' => [
        'class' => \yii\filters\Cors::class,
        'cors' => [
            // restrict access to domains:
            'Origin' => ['http://localhost:8082'], // 允许访问的域名
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            'Access-Control-Allow-Credentials' => true,
            'Access-Control-Max-Age' => 3600,
            'Access-Control-Allow-Headers' => ['*'], // 如访问需要的请求头
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
