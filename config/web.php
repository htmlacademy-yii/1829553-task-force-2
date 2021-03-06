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
      'cookieValidationKey' => 'UAXm_VTNblR_ThFAj3uNLYHzlSeIVa4c',
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
      'class' => 'yii\swiftmailer\Mailer',
      // send all mails to a file by default. You have to set
      // 'useFileTransport' to false and configure a transport
      // for the mailer to send real emails.
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
        'enableStrictParsing' => false,
        'rules' => [
            '/' => 'landing/index',
            'tasks/view/<id>' => 'tasks/view',
            'tasks/cancel/<id>' => 'tasks/cancel',
            'tasks/refuse/<id>' => 'tasks/refuse',
            'tasks/accept-bid' => 'tasks/accept-bid',
            'user/view/<id>' => 'user/view',
            'bid/refuse/<id>' => 'bid/refuse',
            'bid/create' => 'bid/create',
            'ajax/geo/<address>' => 'ajax/get-geo',
        ],
    ],
    'formatter' => [
      'dateFormat' => 'dd.MM.yyyy',
      'decimalSeparator' => ',',
      'thousandSeparator' => ' ',
      'currencyCode' => 'EUR',
      'locale' => 'ru_Ru'
    ],
    'authClientCollection' => [
      'class' => 'yii\authclient\Collection',
      'clients' => [
          'vkontakte' => [
              'class' => 'yii\authclient\clients\VKontakte',
              'clientId' => '8047101',
              'clientSecret' => 'jaEXhFjnwHlwmz7GKMw1',
              'scope' => ['email']
          ],
      ],
    ]
  ],
  'params' => $params,
];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
    'allowedIPs' => ['127.0.0.1', '::1', '*'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
    'allowedIPs' => ['127.0.0.1', '::1', '*'],
  ];
}

return $config;
