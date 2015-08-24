<?php

$dbName = ('live' === $_SERVER['environment']) ? 'edincent' : 'edincent_dev';

if('live' === $_SERVER['environment'])
{
    $iglobalApiUrl = 'https://api-dot-iglobaldev.appspot.com/api/v1';
}
else
{
    $iglobalApiUrl = strpos(getenv("SERVER_SOFTWARE"), 'Development') === 0  
                ? 'http://localhost:8080/api/v1' 
                : 'https://dev-dot-iglobaldev.appspot.com/api/v1';
}

return [
    'name'       => 'Education Incentive',
    'language' => 'en-US',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules'    => [
        'redactor' => 'yii\redactor\RedactorModule',
    ],
    
    'components' => [
        'cache' => [
            'class' => (strpos(getenv("SERVER_SOFTWARE"), 'Development') === 0) ? 'yii\caching\DummyCache' : 'yii\caching\MemCache',
        ],
        
        'session' => [
            'class' => '\yii\web\DbSession',
			'name' => 'S',
			'useCookies' => true,			
			'db' => 'db',
			'sessionTable' => 'SiteSession',			
		],
        
        'assetManager' => [
            // This is special Asset Manger which can work under Google App Engine
            'class'    => 'common\components\CGAssetManager',
            // CHANGE THIS: Enter here your own Google Cloud Storage bucket name Google App Engine
            'basePath' => strpos(getenv("SERVER_SOFTWARE"), 'Development') === 0 
                    ? '@frontend/web/assets'  // basePath for development version, assets path alias was defined above
                    : 'gs://educationincentive.appspot.com/assets', // basePath for production version
            // CHANGE THIS: All files on Google Cloud Storage can be accessed via the URL below,
            // note the bucket name at the end, should be the same as in basePath above
            'baseUrl'  => strpos(getenv("SERVER_SOFTWARE"), 'Development') === 0 ? '/assets'                                            // baseUrl for development App Engine
                    : '//commondatastorage.googleapis.com/educationincentive.appspot.com/assets', // baseUrl for production App Engine
            'bundles'  => [
                /*'yii\web\JqueryAsset'                => [
                    'sourcePath' => null,
                    'js'         => ['//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js']],
                'yii\jui\JuiAsset'                   => [
                    'sourcePath' => null,
                    'css'        => ['//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'],
                    'js'         => ['//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js']],*/
                'yii\bootstrap\BootstrapAsset'       => [
                    'sourcePath' => null,
                    'css'        => ['css/bootstrap/css/bootstrap.min.css', 'css/bootstrap/font-awesome/css/font-awesome.min.css']
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js'         => ['js/bootstrap.min.js'],
                ],
            ]
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'baseUrl'         => '', // added to fix URL issues under Google App Engine
            'showScriptName'  => false,
            'rules'           => [
                '' => 'site/index',
                '<view:(support|user-agreement|privacy-policy|about|school-rewards)>' => 'site/page',
                '<action:(surveyDone)>' => 'site/survey-done',
                '<action:(sign-up|contact|unsubscribe|login|request-password-reset|school-dashboard|ajax-school-search)>' => 'site/<action>',
                'dashboard/profile/<profileId:\d+>'=>'dashboard/profile',
                'dashboard/start-survey/<invitationId:\d+>'=>'dashboard/start-survey',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',			
			],
		],
		
		'authManager' => [
			'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['panelist', 'adminUser'],
            'itemFile'     => '@common/rbac/items.php',
            'ruleFile'     => '@common/rbac/rules.php',
        ],
        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\SyslogTarget',                    
                ],
            ]
        ],
        
        'db' => [
            'class'    => 'common\components\CustomDbConnection',
            'dsn'      => strpos(getenv("SERVER_SOFTWARE"), 'Development') === 0 // local development server connection string
                    ? 'mysql:host=192.168.56.101;dbname=' . $dbName
            // App Engine Cloud SQL connection string
            // explanation:
            // yii-framework - here is a name of App Engine project
            // db - here is the name of Cloud SQL instance
                    : 'mysql:unix_socket=/cloudsql/educationincentive:instance1;dbname='.$dbName.';charset=utf8',
            'username' => 'root',
            'password' => strpos(getenv("SERVER_SOFTWARE"), 'Development') === 0 ? '5c00byd00' : '',
            'enableSchemaCache' => true,
            'charset' => 'utf8'
        ],
        
        'mailer' => [
            'class'    => 'common\components\GAEMailer',
            'viewPath' => '@common/mail',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        //'useFileTransport' => true,
        ],
        
        'formatter' => [
            'locale' => 'en-US',
            'currencyCode' => 'USD',
            'nullDisplay' => '',
        ],
        
        'iglobalApi' => [
            'class' => 'common\components\IGlobalApi',
            'panelKey' => '10$SIHNo',
            'panelSecret' => 'Z2t_xiW6OGhlAeC-mMB6owsgNaFlRLFh',
            'apiUrl' => $iglobalApiUrl,
            'resourceId' => 3
        ],
    ],
];
