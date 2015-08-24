<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\console\controllers\MigrateController;
use backend\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'column2';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'login', 
                            'error'
                            ],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout', 
                            'index',
                            'migrations',                           
                            ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',                
            ],
        ];
    }
    
    public function actionIndex()
    {
        $this->layout = 'column1';
        if(!Yii::$app->user->isGuest)
        {
            return $this->redirect('/backend/user');
        }
        
        //run initial migration script if first time.
        $sql = "select version from tbl_migration;";
        try{
            $result = Yii::$app->db->createCommand($sql)->queryScalar();
        }
        catch(\yii\db\Exception $e)
        {
            // do nothing
        }
        if(!$result)
        {
            $this->runMigrationTool();
        }
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = 'column1';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/backend');
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->destroy();

        return $this->goHome();
    }
	
	function actionMigrations()
	{
		if($_POST['RunMigrations'])
		{
			$output = $this->runMigrationTool();
            Yii::$app->session->setFlash('success', $output);
		}
		else if($_POST['CreateMigration']['migrationName'])
		{
			$output = $this->createMigration($_POST['CreateMigration']['migrationName']);
            Yii::$app->session->setFlash('success', $output);
		}		
        
		return $this->render('migrations');
	}
	
	public function isAppEngineCronRequest($user, $rule)
	{
		return isset($_SERVER["HTTP_X_APPENGINE_CRON"]) && $_SERVER["HTTP_X_APPENGINE_CRON"];
	}
	
	private function runMigrationTool() 
	{
		ob_start();
        $migrateController = new MigrateController('yii\console\controllers\Migrate', Yii::$app->module);
        $migrateController->interactive = false;
        $migrateController->migrationPath = Yii::getAlias('@console/migrations');	
        $migrateController->migrationTable = 'tbl_migration';
        $migrateController->db = Yii::$app->db;
		$migrateController->actionUp();
        
        if(\STDOUT)
        {
            // Read what we have written.
            rewind(\STDOUT);
            echo stream_get_contents(\STDOUT);
            fclose(\STDOUT);            
        }
        
		return htmlentities(ob_get_clean(), null, Yii::$app->charset);
	}
	
	private function createMigration($migrationName) 
	{
		ob_start();
		$migrateController = new MigrateController('yii\console\controllers\Migrate', Yii::$app->module);
        $migrateController->interactive = false;
        $migrateController->migrationPath = Yii::getAlias('@console/migrations');        
        $migrateController->migrationTable = 'tbl_migration';
        $migrateController->db = Yii::$app->db;
		$migrateController->actionCreate($migrationName);
        
        if(\STDOUT)
        {
            // Read what we have written.
            rewind(\STDOUT);
            echo stream_get_contents(\STDOUT);
            fclose(\STDOUT);            
        }
        
		return htmlentities(ob_get_clean(), null, Yii::$app->charset);
	}
}
