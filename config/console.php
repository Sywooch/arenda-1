<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            //'enableAutoLogin' => true,
        ],
        'mailer'       => $params['mailer'],
        'session' => [ // for use session in console application
            'class' => 'yii\web\Session'
        ],
        'db' => $db,
        'urlManager'   => [
			'enablePrettyUrl'     => true,
			'enableStrictParsing' => false,
			'showScriptName'      => false,
			'baseUrl'			  => 'http://' . $params['tld'],
			'rules'               => [
				'<controller:[\w-]+>/<action:[\w-]+>'          => '<controller>/<action>',
				'<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
			],
		],
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
}

return $config;
