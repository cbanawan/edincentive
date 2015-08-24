<?php
namespace frontend\controllers;

use Yii;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\tables\CashOutChoice;
use common\models\identities\Panelist;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
	public $layout = 'column1';
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'transparent' => true,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => \yii\web\ViewAction::className(),
                'viewPrefix' => 'pages',
            ),
        ];
    }

    public function actionIndex()
    {
        $this->view->title = "EdIncentive - Discover How You Can Help Local Schools";
        $this->view->registerMetaTag(['name' => 'title', 'content' => $this->view->title], 'title');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => "PTA, fundraising ideas, fundraiser, school, education"], 'keywords');
        $this->view->registerMetaTag(['name' => 'description', 'content' => "EdIncentive is an education platform that specializes in helping parents and educators raise funds for local schools."], 'description');
        $this->view->registerJsFile('/js/ajaxLoader.js',['position' => \yii\web\View::POS_HEAD]);
        
		if(Yii::$app->user->identity->id)
		{
			return $this->redirect('/dashboard');
		}
		$signupForm = new \frontend\models\SignupForm();
		// collect user input data
		if($signupForm->load(Yii::$app->request->post()))
		{
			$coordinates = explode(',', $_SERVER['HTTP_X_APPENGINE_CITYLATLONG']);
			$signupForm->postal = $this->getPostalFromCoordinates($coordinates[0], $coordinates[1]); // calculate zip from latitude & longitude
			
            if(empty($signupForm->postal))
				$signupForm->postal = '00000';
						
			// for ajax validation
			if (Yii::$app->request->isAjax || (isset($_POST['ajax']) && $_POST['ajax'] === 'joinForm'))
			{
               Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
               return ActiveForm::validate($signupForm);				
			}
            
            if($signupForm->validate())
            {
				$result = $signupForm->join();
                if($result['confirmCode'] && !$signupForm->hasErrors())
				{
					Yii::$app->mailer->compose('memberSignup', [
						'memberId' => $result['memberId'],
						'userName' => $signupForm->firstName,
						'confirmCode' => $result['confirmCode']
						])
                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                    ->setTo($signupForm->email)
                    ->setSubject('Thank you for joining ' . \Yii::$app->name . '!')
                    ->send();
					
                    $loginForm = new LoginForm();
                    $loginForm->email = $signupForm->email;
                    $loginForm->password = $signupForm->password;
                    $loginForm->login();
                    return $this->redirect('/dashboard');
				}
                
            }
		}
		
		// year of birth
		$yearOfBirthList = array();
		$year = date('Y'); 
		for($i=$year; $i>($year - 100); $i--)
		{
			$yearOfBirthList[$i] = $i;
		}
        
        $this->view->registerJsFile('/js/jquery.passstrength.min.js.js', ['position' => \yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
		
        return $this->render('index',[
			'joinModel' => $signupForm,
			'yearOfBirthList' => $yearOfBirthList,
		]);
    }
    
    public function actionSignUp()
    {
        $this->view->title = "Turn Spare Time into Spare Change for Local Schools";
        $this->view->registerMetaTag(['name' => 'title', 'content' => $this->view->title], 'title');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => "parent, teacher, rewards"], 'keywords');
        $this->view->registerMetaTag(['name' => 'description', 'content' => "Joining is free and easy, and participation in surveys is simple. To sign up, you will answer some basic questions that will take less than a minute."], 'description');
        $this->view->registerJsFile('/js/ajaxLoader.js',['position' => \yii\web\View::POS_HEAD]);
        
        if(Yii::$app->user->identity->id)
		{
			return $this->redirect('/dashboard');
		}
		$signupForm = new \frontend\models\SignupForm();
		// collect user input data
		if($signupForm->load(Yii::$app->request->post()))
		{
			$coordinates = explode(',', $_SERVER['HTTP_X_APPENGINE_CITYLATLONG']);
			$signupForm->postal = $this->getPostalFromCoordinates($coordinates[0], $coordinates[1]); // calculate zip from latitude & longitude
			
            if(empty($signupForm->postal))
				$signupForm->postal = '00000';
						
			// for ajax validation
			if (Yii::$app->request->isAjax || (isset($_POST['ajax']) && $_POST['ajax'] === 'joinForm'))
			{
               Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
               return ActiveForm::validate($signupForm);				
			}
            
            if($signupForm->validate())
            {
				$result = $signupForm->join();
                if($result['confirmCode'] && !$signupForm->hasErrors())
				{
					Yii::$app->mailer->compose('memberSignup', [
						'memberId' => $result['memberId'],
						'userName' => $signupForm->firstName,
						'confirmCode' => $result['confirmCode']
						])
                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                    ->setTo($signupForm->email)
                    ->setSubject('Thank you for joining ' . \Yii::$app->name . '!')
                    ->send();
					
                    $loginForm = new LoginForm();
                    $loginForm->email = $signupForm->email;
                    $loginForm->password = $signupForm->password;
                    $loginForm->login();
                    return $this->redirect('/dashboard/school-donation-select');
				}
                
            }
		}
		
		// year of birth
		$yearOfBirthList = array();
		$year = date('Y'); 
		for($i=$year; $i>($year - 100); $i--)
		{
			$yearOfBirthList[$i] = $i;
		}
        
        $this->view->registerJsFile('/js/jquery.passstrength.min.js.js', ['position' => \yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
		
        return $this->render('signup',[
			'signupForm' => $signupForm,
			'yearOfBirthList' => $yearOfBirthList,
		]);
    }

    public function actionLogin()
    {
        $this->view->title = "EdIncentive Login - Help Raise Funds for Local Schools";
        $this->view->registerMetaTag(['name' => 'title', 'content' => $this->view->title], 'title');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => "education rewards"], 'keywords');
        $this->view->registerMetaTag(['name' => 'description', 'content' => "Login to access your rewards and refer others to your campaign."], 'description');
        
        if (!\Yii::$app->user->isGuest) {
            if(!CashOutChoice::find()->where(['memberId' => Yii::$app->user->identity->id])->exists())
            {
                return $this->redirect('/dashboard/school-donation-select');
            }
            
            return $this->redirect('/dashboard');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(!CashOutChoice::find()->where(['memberId' => Yii::$app->user->identity->id])->exists())
            {
                return $this->redirect('/dashboard/school-donation-select');
            }
            return $this->redirect('/dashboard');
        } 
		
		return $this->render('login', [
                'model' => $model,
            ]);
    }
    
    public function actionConfirm($code, $mId)
    {
        $countryCode = $countryCode = $_SERVER['HTTP_X_APPENGINE_COUNTRY'];
        
        $result = Yii::$app->iglobalApi->confirm(['memberId' => $mId,
            "confirmCode" => $code,
            "countryCode" => $countryCode 
            ]);
        
        if($result['memberId'])
        {
            Yii::$app->session->setFlash("success", "Your email address: {$result['email']} was successfully confirmed!");
            if(!Yii::$app->user->isGuest && Yii::$app->user->identity)
            {
                Yii::$app->user->identity->statusId = 3;
            }            
        }
        else
        {
            Yii::$app->session->setFlash("danger", implode('<br/>', $result['errors']));
        }
        
        return $this->redirect('/dashboard');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $contactForm = new ContactForm();
        if($_POST['ContactForm'])
		{
			if ($contactForm->load(Yii::$app->request->post()) && $contactForm->validate())
			{
				if ($contactForm->sendEmail())
				{
					Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
				}
				else
				{
					Yii::$app->session->setFlash('error', 'There was an error sending email.');
				}
			}
		}	 
        
		return $this->render('@frontend/views/site/pages/support', ['contactForm' => $contactForm, 'tabOptions' => ['active' => 1]]);        
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', "A password reset request was sent to: {$model->email}. Please follow the instructions in the email to reset your password.");
                $model = new PasswordResetRequestForm();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token, $mId)
    {
        $panelist = new Panelist(['id' => $mId]);
        $model = new ResetPasswordForm($panelist);
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->currentPassword = $token;
            $model->resetPassword();
            if(!$model->hasErrors())
            {
                Yii::$app->getSession()->setFlash('success', 'New password was saved. You may now login using the new password.');
            }            
        }

        return $this->render('resetPassword', [
            'formModel' => $model,
        ]);
    }
    
    public function actionSurveyDone()
    {
        //default message
        $message = "<p>Thank you for responding to our survey.</p>";
       
        if ($_GET['st'])
        {
            switch($_GET['st'])
            {
                case 1:
                    $message = '<p>Thank you for completing our survey. Your time and thoughtful responses are greatly appreciated.<br/>
                                Your incentive earnings will be automatically credited to your account.<br/>
                                <br/> 
                                To check your account, please <a href="/dashboard">log in</a>.</p>';
                    break;
                case 2:
                    $message = '<p>Thank you for responding to our survey invitation! <br/>
                                <br/>
                                We are sorry you were not able to complete this survey. Unfortunately, you did not match the criteria required for this survey. 
                                Please know we appreciate your time and efforts and will soon send you another survey opportunity.</p>';
                    break;
                case 3:
                    $message = '<p>Thank you for responding to our survey invitation!<br/>
                                <br/>
                                We are sorry you were not able to complete this survey. Unfortunately, you did not match the criteria required for this survey. We appreciate your participation.</p>';
                    break;
                case 4:
                    $message = '<p>Thank you for responding to our survey. Unfortunately, we have already achieved enough responses for this specific target group. Please know your time and efforts are greatly appreciated.</p>';
                    break;
                case 5:
                    $message = '<p>You have declined to participate in this survey. We look forward to your participation in future surveys.</p>';
                    break;
                case 9:
                    $message = '<p>We were not able to find a survey for you.</p>';
                    break;
            }
        }

        return $this->render('surveyDone', array('message' => $message));
    }
    
    public function actionSchoolDashboard($schoolId)
    {
        $schoolData = Yii::$app->iglobalApi->getSchoolStats($schoolId);
        $this->view->title = $schoolData['schoolName'].", ".$schoolData['city'].", ".$schoolData['state'].", Fundraising";
        $this->view->registerMetaTag(['name' => 'title', 'content' => $this->view->title], 'title');
        $this->view->registerMetaTag(['name' => 'keywords', 'content' =>  $schoolData['schoolName'].", school fundraising"], 'keywords');
        $this->view->registerMetaTag(['name' => 'description', 'content' =>  $schoolData['schoolName']." fundraising page"], 'description');
        
        // opengraph tags for sharing
        $this->view->registerMetaTag(['content' => Yii::$app->name, 'property' => 'og:site_name'], 'og:site_name');
        $this->view->registerMetaTag(['content' => Yii::$app->urlManager->createAbsoluteUrl(Yii::$app->request->url), 'property' => 'og:url'], 'og:url');
        $this->view->registerMetaTag(['content' => 'article', 'property' => 'og:type'], 'og:type');
        $this->view->registerMetaTag(['content' => $this->view->title, 'property' => 'og:title'], 'og:title');
        $this->view->registerMetaTag(['content' => $schoolData['schoolName']." fundraising page", 'property' => 'og:description'], 'og:description');
        $this->view->registerMetaTag(['content' => Yii::$app->urlManager->createAbsoluteUrl('/images/logo-med.png'), 'property' => 'og:image'], 'og:image');
        $this->view->registerMetaTag(['content' => Yii::$app->params['fb_app_id'], 'property' => 'fb:app_id'], 'fb:app_id');
                
        return $this->render('schoolDashboard',['schoolData' => $schoolData]);
    }
    
    public function actionAjaxSchoolSearch()
    {
        // accept only AJAX requests
		if (!Yii::$app->request->isAjax) 
		{
            exit();
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;        
		$postVars = Yii::$app->request->post();
		$searchParams = [];
		foreach($postVars['school-search-formData'] as $key=>$value)
		{
			if($value !== '')
			{
				$searchParams[\yii\helpers\BaseInflector::variablize($key)] = $value;
			}			
		}
        $schoolList = Yii::$app->iglobalApi->searchSchools($searchParams);
        $data = [];
        if($schoolList['count'] > 0 )
        {
            if($schoolList['count'] > 50)
            {
                $data['errors'] = 'Only the first 50 schools are shown. Please add more information to narrow down your search.';
            }
                       
            foreach($schoolList['models'] as $sch)
            {
                $school = [];
                $school['responseId'] = $sch['schoolId'];
                $school['responseText'] = $sch['schoolName'] . ', ' . $sch['city'] . ', ' . $sch['state'];
                $data['schools'][] = $school;
            }            
        }        
        
        return $data;
    }
    
    private function getPostalFromCoordinates($lat, $long)
	{
		$db = Yii::$app->db;
		
		$sql = "SELECT locationPostalCode, :distanceUnit * DEGREES(ACOS(COS(RADIANS(:latitude)) * COS(RADIANS(locationLatitude)) * COS(RADIANS(:longitude - locationLongitude)) + SIN(RADIANS(:latitude)) * SIN(RADIANS(locationLatitude)))) AS distance "
				. "FROM Location "
				. "WHERE locationLatitude "
				. "BETWEEN :latitude - (:radius / :distanceUnit) AND :latitude + (:radius / :distanceUnit) "
				. "AND locationLongitude "
				. "BETWEEN :longitude - (:radius / (:distanceUnit * COS(RADIANS(:latitude)))) AND :longitude + (:radius / (:distanceUnit * COS(RADIANS(:latitude)))) "
				. "HAVING distance <= :radius "
				. "ORDER BY distance "
				. "LIMIT 1";		
		
		return $db->cache(function($db) use($sql,$lat,$long){
			$command = $db->createCommand($sql);
			$command->bindValues([
			':latitude' => $lat,
			':longitude' => $long,
			':distanceUnit' => 111.045,
			':radius' => 50, //50 mile radius
			]);
			$command->queryScalar();
			});
	}
}
