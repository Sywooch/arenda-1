<?php

$params = require(__DIR__ . '/params.php');

$config = [
	'id'         => 'frontend',
	'name'       => 'ARENDA',
	'basePath'   => dirname(__DIR__),
    'sourceLanguage' => 'ru-RU',
	'language'   => 'ru-RU',
	'bootstrap'  => ['log'],
	'modules'    => [
		'admin' => [
			'class' => 'app\modules\admin\Admin',
		],
		'gii'   => [
			'class'      => 'yii\gii\Module',
			'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*'],
		],
	],
	'components' => [
		'html2pdf' => [
			'class' => 'yii2tech\html2pdf\Manager',
			'viewPath' => '@app/pdf',
			'converter' => [
				'class' => 'yii2tech\html2pdf\converters\Wkhtmltopdf',
				'defaultOptions' => [
					'dpi'       => '96',
					'margin-bottom' => '0',
					'margin-left'=>'0',
					'margin-right'=>'0',
					'margin-top'=>'0',
					'pageSize' => 'A4',
				],
			]
		],
	    'inplat'=>$params['inplat'],
		'sms'       => $params['sms'],
		'request'      => [
			'class'                => 'app\components\Request',
			'enableCsrfValidation' => true,
			'cookieValidationKey'  => 'R9m0pVe1Kd9GN6eg5LxM13????',
		],
		'cache'        => [
			'class' => 'yii\caching\FileCache',
		],
		'user'         => [
			'identityClass'   => 'app\models\User',
			'enableAutoLogin' => true,
			'loginUrl'        => ['/#login'],
		],
		'authManager'  => [
			'class'        => 'yii\rbac\DbManager',
			'defaultRoles' => ['guest'],
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'mailer'       => $params['mailer'],
		'log'          => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'    => [
				[
					'class'  => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db'           => require(__DIR__ . '/db.php'),
		'urlManager'   => [
			'enablePrettyUrl'     => true,
			'enableStrictParsing' => false,
			'showScriptName'      => false,
			'rules'               => [

				// Index
				'/'                                         => '/pages/view',

				// Заглушки
				'landlord'                                  => 'site/under-construction',
				'renter'                                    => 'site/under-construction',

				// Shortcuts
				//'profile'                                   => 'user/profile',

				// Ссылка на прямую ведёт на шаг - что бы можно было выстроить подсказки для каждого шага
				'ads/create/<step:\d+>'                     => 'ads/create',
				'lease-contracts/create/<step:\d+>'         => 'lease-contracts/create',

				// Admin
				'admin'                                     => 'admin/',
				'admin/<action:[\w-]+>'                     => 'admin/default/<action>',
				'admin/<controller:[\w-]+>/<action:[\w-]+>' => 'admin/<controller>/<action>',

				'<controller:[\w-]+>/<action:[\w-]+>'          => '<controller>/<action>',
				'<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',

				// last try ;)
				//'/<url:(.*)>'                                   => '/pages/view',
			],
		],
	],
	'params'     => $params,
];

if (strpos($_SERVER['REQUEST_URI'], '/admin', 0) === false) {
	$config['components']['assetManager'] = [
		'bundles' => [
			'yii\bootstrap\BootstrapAsset'       => [
				'css' => [],
			],
			'yii\bootstrap\BootstrapPluginAsset' => [
				'js' => [],
			],
		],
	];

	// Global template set
	\Yii::$container->set('yii\bootstrap\ActiveField', [
		'template' => "{error}\n{input}\n{hint}"
	]);

	\Yii::$container->set('yii\grid\GridView', [
		'summary' => '',
	]);

	\Yii::$container->set('yii\widgets\ListView', [
		'summary' => '',
	]);
}

if (YII_DEBUG) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class'      => 'yii\gii\Module',
		'allowedIPs' => ['*'],
	];
}

return $config;
