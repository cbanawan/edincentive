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
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' =>[      
    ],
    
    'components' => [
        'user' => [
            'identityClass' => 'common\models\identities\Panelist',
            'enableAutoLogin' => true,
            'loginUrl' => '/login',
        ],
        
		'request'=>[
			'baseUrl'=>'', // added to fix URL issues under Google App Engine
			'cookieValidationKey' => '049578hjgoerkhgodhejhsdffg38746tr534',
		],
				
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],        
    ],
    'params' => $params,
];
return $config;