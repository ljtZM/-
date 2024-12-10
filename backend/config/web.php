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
        'authManager' => [
        'class' => 'yii\rbac\DbManager', // 使用数据库存储RBAC数据
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5XGMxIAL5IX9xS0emFdBn7RCrnccKQpI',
            'enableCsrfValidation' => false 
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
                'api/login' => 'api/authenticate',
                'api/signup' => 'api/register',
                'api/adminlogin' => 'api/adminlogin',

                'api/getarticle' => 'api/getarticle',
                'api/getarticlepagecount' => 'api/getarticlepagecount',
                'api/getarticlecomment' => 'api/getarticlecomment',
                'api/addarticlecomment' => 'api/addarticlecomment',
                'api/getarticlelikes' => 'api/getarticlelikes',
                'api/addarticlelikes' => 'api/addarticlelikes',

                'api/getvideo' => 'api/getvideo',
                'api/getvideopagecount' => 'api/getvideopagecount',
                'api/getvideocomment' => 'api/getvideocomment',
                'api/addvideocomment' => 'api/addvideocomment',
                'api/getvideolikes' => 'api/getvideolikes',
                'api/addvideolikes' => 'api/addvideolikes',

                'api/getclick' => 'api/getclick',
                'api/addclick' => 'api/addclick',

                'api/getpersonalinfo' => 'api/getpersonalinfo',

                'api/addwebviews' => 'api/addwebviews',
                'api/checkwebviews' => 'api/checkwebviews',
            ],
        ],  

        'response' => [
            // 'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->headers->set('Access-Control-Allow-Origin', '*');//设置跨域
                $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                $response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
                //$event->sender->headers->remove('Access-Control-Allow-Origin');//这个是删除跨域规则
            },
        ],
    ],
    'params' => $params,
];

if (!YII_ENV_TEST) {
    // 配置调试工具栏（可选）
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // 允许的 IP 地址
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    // 启用 Gii 模块
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // 允许的 IP 地址
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
