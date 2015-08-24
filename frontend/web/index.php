<?php
error_reporting(E_ALL ^ E_NOTICE);
defined('YII_DEBUG') or define('YII_DEBUG', (strpos(getenv("SERVER_SOFTWARE"), 'Development') === 0)?true:false);
defined('YII_ENV') or define('YII_ENV', ('live' === $_SERVER['environment']) ? 'live' : 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
		
	(is_file(__DIR__ . '/../../common/config/main-local.php'))
	? require(__DIR__ . '/../../common/config/main-local.php')
	: [],
		
    require(__DIR__ . '/../config/main.php'),
	
	(is_file(__DIR__ . '/../config/main-local.php'))
	? require(__DIR__ . '/../config/main-local.php')
	: []    
);

$application = new yii\web\Application($config);
$application->run();
