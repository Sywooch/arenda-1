<?php

$localFile = __DIR__ . '/params-local.php';
$localParams = is_file($localFile) ? require $localFile : [];

$params = [
    'adminEmail' => 'muxtorsoft@mail.ru',
    'supportEmail' => 'muxtorsoft@mail.ru',
    'infoEmail' => 'info@arenda.ru',
    'user.passwordResetTokenExpire' => 3600,
    'currency' => 'RUR',
    'tld' => 'arenda.ru',
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.mail.ru',
            'username' => 'muxtorsoft@mail',
            'password' => 'muxtorsoft',
            'port' => '465',
            'encryption' => 'ssl',
        ],
    ],
    'sms' => [
        'class' => 'Zelenin\yii\extensions\Sms',
        'api_id' => 'F90C372A-7A1E-D000-602F-???????',
    ],
    'kladrToken' => '585e73590a6??????',
    'inplat' => [
        'class' => 'app\components\Inplat',
        'apiKey' => '1kzXPVZYkkz?????',
        'secretCode' => 'WxFibVy4L??????',
    ],
    'twitter' => [
	    'api_key'     => '',
	    'api_secret'  => '',
	    'screen_name' => '',
	    'count'       => 2,
    ],
    'pdfs'=>'@app/web/pdfs',
    'pdfsweb'=>'/pdfs',
];

return array_merge($params, (is_array($localParams) ? $localParams : []));
