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

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'console\controllers',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
    ],
    'params' => $params,
];
