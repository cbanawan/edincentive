<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    
	(is_file(__DIR__ . '/../../common/config/params-local.php'))
	? require(__DIR__ . '/../../common/config/params-local.php')
	: [],
	
    require(__DIR__ . '/params.php'),
	
	(is_file(__DIR__ . '/params-local.php'))
	? require(__DIR__ . '/params-local.php')
	: []
);

$config = [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',
    'modules' =>[],    
    'components' => [
        'user' => [
            'identityClass' => 'common\models\identities\AdminUser',
            'enableAutoLogin' => true,
            'idParam' => '__adm_id',
            'loginUrl' => '/backend/site/login',
        ],
		
		'request'=>[
			'baseUrl'=>'/backend',
			'cookieValidationKey' => 'thsdv34t3gf374732gv',
		],
				
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
    ],
    'params' => $params,
];
return $config;
