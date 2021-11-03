<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];

    $config['controllerMap'] = [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'templatePath' => '@app/fixtures/templates',
            'fixtureDataPath' => '@app/fixtures/data',
            'language' => 'ru_RU',
            'namespace' => 'app\fixtures',
            'providers' => [
                'app\fixtures\providers\User',
                'app\fixtures\providers\Task',
//                'app\fixtures\providers\Bid',
//                'app\fixtures\providers\Review',
                'app\fixtures\providers\City',
                'app\fixtures\providers\Status',
                'app\fixtures\providers\Category',
            ],

        ],
    ];
}

return $config;
