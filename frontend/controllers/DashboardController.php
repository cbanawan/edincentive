<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\base\Event;
use yii\web\Response;
use frontend\models\ResetPasswordForm;
use frontend\models\ChangeEmailForm;
use frontend\models\ContactForm;
use frontend\models\SchoolDonationForm;
use common\models\tables\CashOutChoice;

class DashboardController extends Controller
{
	public $layout = 'column2';
    
    public function init()
    {
        $this->view->registerJsFile('/js/ajaxLoader.js',['position' => \yii\web\View::POS_HEAD]);
        return parent::init();
    }
	
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['class'] = AccessControl::className();
        $behaviors['access']['rules'] = [
            [
                'actions' => [
                        'index',
                        'my-account',
                        'support',
                        'cash-out',
                        'profile',
                        'send-confirmation-email',
                        'ajax-survey-next-button',
                        'ajax-survey-previous-button',
                        'ajax-survey-start-over',
                        'ajax-load-default-cashout',
                        'ajax-load-member-transactions',
                        'ajax-load-member-invites',
                        'ajax-school-search',
						'school-donation-select',
                        'start-survey'
                    ],
                'allow' => true,
                'roles' => ['panelist']
            ],
        ];
        
        return $behaviors;
    }
    
    public function actionIndex()
    {
        $latestProfile = Yii::$app->iglobalApi->getLatestProfile(Yii::$app->user->identity->id);
        
        if (Yii::$app->user->identity->statusId == 1) //unconfirmed Status
        {
            $resendConfirmLink = Yii::$app->urlManager->createAbsoluteUrl('/dashboard/send-confirmation-email');
            if(!Yii::$app->session->hasFlash('success'))
            {
                Yii::$app->session->setFlash('success', "A confirmation email was sent to:".Yii::$app->user->identity->email."<strong> Please click on the link in the email to confirm your account</strong>. You will receive survey invites through your email so you need to confirm your account before you start receiving survey invites.<br/>
                    <br/>
                    If you are having trouble finding the confirmation email, <a href=\"$resendConfirmLink\">Click here</a> to re-send it.");
            }
        }
        
        $this->view->registerJsFile('/js/react-with-addons.min.js', ['position' => \yii\web\View::POS_HEAD]);
        $this->view->registerCss('
            .fade-appear {opacity: 0.01; transition: opacity .5s ease-in;}
            .fade-appear.fade-appear-active {opacity: 1;}
            ', 
            ['position' => \yii\web\View::POS_HEAD]);
        
        return $this->render('index',[
            'profileId' => $latestProfile,
        ]);
    }
    
    public function actionMyAccount()
    {
        $transactions = Yii::$app->iglobalApi->getMemberTransactions(Yii::$app->user->identity->id);
        
        $member = Yii::$app->user->identity;
		
		$resetPasswordForm = new ResetPasswordForm($member);
		$resetPasswordForm->requireOldPassword = true;
		
		$accordionOptions['active'] = false;
		
		if(isset($_POST['ResetPasswordForm']))
		{
			$resetPasswordForm->attributes = $_POST['ResetPasswordForm'];

			if($resetPasswordForm->validate())
			{
				$resetPasswordForm->resetPassword();
				if(!$resetPasswordForm->hasErrors())
				{
					Yii::$app->session->setFlash('success', "Your password has been reset. You may now login using your new password.");
                                
					// Clear out password reset data
					$resetPasswordForm  = new ResetPasswordForm($member);
					$resetPasswordForm->requireOldPassword = true;					
				}				
			}
			
			$accordionOptions['active'] = 0;
		}
		
		$changeEmailForm = new ChangeEmailForm($member);
		$emailUpdateRequestSent = false;
		if(isset($_POST['ChangeEmailForm']))
		{
			if($changeEmailForm->load(Yii::$app->request->post()) && $changeEmailForm->validate())
			{
				if($result = $changeEmailForm->saveEmail())
                {
                    if($result['errors'])
                    {
                        $changeEmailForm->addErrors(['email' => $result['errors']]);
                    }
                    else
                    {
                        Yii::$app->mailer->compose('memberConfirm', [
						'memberId' => Yii::$app->user->identity->id,
						'userName' => Yii::$app->user->identity->firstName,
						'confirmCode' => $result['confirmCode']
						])
                        ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                        ->setTo($changeEmailForm->email)
                        ->setSubject(\Yii::$app->name . ' email address change confirmation.')
                        ->send();
                        
                        Yii::$app->session->setFlash('success', 'We sent an email to your new email address to confirm this action. Please click on the link in the email to proceed with the change.
                        <br /><br />
                        <strong>New Email:</strong> '.$changeEmailForm->email);
                    }
                }
			}
			
			$accordionOptions['active'] = 1;
		}
		
		if(isset($_POST['unsubscribe']) && $_POST['unsubscribe'])
		{
			Yii::$app->iglobalApi->unsubscribe($member->id);
            Yii::$app->session->setFlash('success','Your account is now unsubscribed. You will no longer receive survey invitations.');
			$accordionOptions['active'] = 2;
		}
		
		$this->view->registerJsFile('/js/jquery.passstrength.min.js.js', ['position' => \yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
        
        return $this->render('myAccount',[
            'accordionOptions' => $accordionOptions,
            'transactions' => $transactions,
            'resetPasswordForm' => $resetPasswordForm,
            'changeEmailForm' => $changeEmailForm,
        ]);
    }
    
    public function actionSupport()
    {
        $member = Yii::$app->user->identity;
		$contactForm = new ContactForm();
		$contactForm->name = $member->firstName.' '.$member->lastName;
		$contactForm->email = $member->email;
		
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
        
		return $this->render('@frontend/views/site/pages/support', ['contactForm' => $contactForm]);
    }
    
    public function actionProfile($profileId = null)
	{
        if(!$profileId)
        {
            $profileId = Yii::$app->iglobalApi->getLatestProfile(Yii::$app->user->identity->id);
            if(!$profileId)
            {
                $profileId = 1;
            }
        }        
		$profiles = Yii::$app->iglobalApi->getMemberProfiles(Yii::$app->user->identity->id);
        return $this->render('profile',[
			'profileId' => $profileId,
			'profiles' => $profiles
 		]);
	}
    
    public function actionCashOut()
    {
        $panelist = Yii::$app->user->identity;
        
        $transactions = Yii::$app->iglobalApi->getMemberTransactions(Yii::$app->user->identity->id);
		$totalCredits = 0;
		$totalPoints = 0;
        $schoolDonationForm = new SchoolDonationForm($this->loadDefaultCashout());
        if($schoolDonationForm->schoolDonationType == '1')
        {
            $schoolDonationForm->schoolName = $schoolDonationForm->schoolDonationTypes[1];
        }

		foreach($transactions as &$transaction)
		{
			if($transaction['cintTransactionTypeKey'] == 'tt_pay')
			{
				$totalCredits -=  floatval($transaction['cintMemberTransactionAmount']);
				$totalPoints -= $transaction['cintMemberTransactionPoints'];
			}
			else
			{
				$totalCredits +=  floatval($transaction['cintMemberTransactionAmount']);
				$totalPoints += $transaction['cintMemberTransactionPoints'];
			}
			
			$transaction['cintMemberTransactionAmount'] = str_ireplace('USD', '$', Yii::$app->formatter->asCurrency($transaction['cintMemberTransactionAmount']));
		}
        
        if($_POST)
		{
            $schoolFormData = Yii::$app->request->post('SchoolDonationForm');
            $cashoutType = $schoolFormData['cashoutType'];
            $donationPercentage = (isset($schoolFormData['donationPercentage'])) ? $schoolFormData['donationPercentage'] : null;
            unset($schoolFormData['cashoutType']);
            unset($schoolFormData['donationPercentage']);
			$schoolDonationForm->load($schoolFormData, '');
            if($totalCredits >=  Yii::$app->params['minimum_member_cashout'] )
			{
                //cash out                
                if($schoolDonationForm->validate())
                {
                    if($donationPercentage)
                    {
                        $paymentDetails['donationPercentage'] = $donationPercentage;
                        $paymentDetails['schoolDonationType'] = $schoolDonationForm->schoolDonationType;
                        if($schoolDonationForm->schoolDonationType == 2)
                        {
                            $paymentDetails['schoolId'] = $schoolDonationForm->schoolId;
                        }
                    }
                    
                    switch($cashoutType)
                    {
                        case 1: //paypal
                            $tabOptions['active'] = 1;
                            $paymentDetails['paymentTypeId'] = 1;
                            if(Yii::$app->iglobalApi->cashOut(Yii::$app->user->identity->id, $paymentDetails))
                            {
                                if($donationPercentage && $donationPercentage == 100)
                                {
                                    if($schoolDonationForm->schoolDonationType == 2)
                                    {
                                        Yii::$app->session->setFlash('success', "Thanks for cashing out! The amount will be donated to {$schoolDonationForm->schoolName}.");
                                        $schoolName = $schoolDonationForm->schoolName;
                                    }
                                    else
                                    {
                                        Yii::$app->session->setFlash('success', 'Thanks for cashing out! The amount will be donated to the Education Incentive Fund.');
                                        $schoolName = "the Education Incentive Fund";
                                    }
                                    
                                    Yii::$app->mailer->compose('cashoutEmail', [
                                    'schoolId' => $schoolDonationForm->schoolId,
                                    'memberName' => Yii::$app->user->identity->firstName,
                                    'schoolName' => $schoolName
                                    ])
                                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                                    ->setTo(Yii::$app->user->identity->email)
                                    ->setSubject("Fundraising Donation to EdIncentive")
                                    ->send();
                                }
                                else
                                {
                                    Yii::$app->session->setFlash('success', 'Thanks for cashing out! The amount will be credited to your Paypal account within half an hour.');
                                }
                                $totalCredits = 0;
                            }
                            else
                            {
                                Yii::$app->session->setFlash('danger', "There was an error in the cashout process. Please <a href=\"/dashboard/support\">contact us</a> about the issue.");
                            }                            
                            break;
                        case 2: //edincentive
                            $tabOptions['active'] = 2;
                            switch($schoolDonationForm->schoolDonationType)
                            {
                                case 1:
                                    $paymentDetails['paymentTypeId'] = 2;
                                    if(Yii::$app->iglobalApi->cashOut(Yii::$app->user->identity->id, $paymentDetails))
                                    {
                                        Yii::$app->session->setFlash('success', 'Thanks for cashing out! The amount will be donated to the Education Incentive Fund.');
                                        $totalCredits = 0;
                                        
                                        Yii::$app->mailer->compose('cashoutEmail', [
                                        'schoolId' => $schoolDonationForm->schoolId,
                                        'memberName' => Yii::$app->user->identity->firstName,
                                        'schoolName' => "the Education Incentive Fund"
                                        ])
                                        ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                                        ->setTo(Yii::$app->user->identity->email)
                                        ->setSubject("Fundraising Donation to EdIncentive")
                                        ->send();
                                    }
                                    else
                                    {
                                        Yii::$app->session->setFlash('danger', "There was an error in the cashout process. Please <a href=\"/dashboard/support\">contact us</a> about the issue.");
                                    }
                                    break;
                                case 2:
                                    $paymentDetails['paymentTypeId'] = 3;
                                    $paymentDetails['schoolId'] = $schoolDonationForm->schoolId;
                                    if(Yii::$app->iglobalApi->cashOut(Yii::$app->user->identity->id, $paymentDetails))
                                    {
                                        Yii::$app->session->setFlash('success', "Thanks for cashing out! The amount will be donated to {$schoolDonationForm->schoolName}.");
                                        $totalCredits = 0;
                                        
                                        Yii::$app->mailer->compose('cashoutEmail', [
                                        'schoolId' => $schoolDonationForm->schoolId,
                                        'memberName' => Yii::$app->user->identity->firstName,
                                        'schoolName' => $schoolDonationForm->schoolName
                                        ])
                                        ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                                        ->setTo(Yii::$app->user->identity->email)
                                        ->setSubject("Fundraising Donation to EdIncentive")
                                        ->send();
                                    }
                                    else
                                    {
                                        Yii::$app->session->setFlash('danger', "There was an error in the cashout process. Please <a href=\"/dashboard/support\">contact us</a> about the issue.");
                                    }
                                    break;                                    
                            }
                            break;
                    }
                }
			}
			else
			{ 
                switch($cashoutType)
                {
                    case 1:
                        $tabOptions['active'] = 1;
                        break;
                    case 2:
                        $tabOptions['active'] = 2;
                        break;
                }
				Yii::$app->session->setFlash('danger', "You don't have enough points to cash out.");
			}
            
            if($schoolDonationForm->validate())
            {
                //save cashout choice
                $cashOutChoice = CashOutChoice::findOne(['memberId' => Yii::$app->user->identity->id]);
                if(!$cashOutChoice)
                {
                    $cashOutChoice = new CashOutChoice();
                    $cashOutChoice->memberId = Yii::$app->user->identity->id;
                }
                $cashOutChoice->schoolDonationType = $schoolDonationForm->schoolDonationType;
                $cashOutChoice->schoolId = $schoolDonationForm->schoolId;
                $cashOutChoice->schoolName = $schoolDonationForm->schoolName;
                $cashOutChoice->save();
            }
		}
        		
		$totalCredits = round($totalCredits, 3);
        $totalCreditsValue = $totalCredits;
		$totalPoints =($totalCredits) ?$totalCredits*100:0;		
		$totalCredits = str_ireplace('USD', '$', Yii::$app->formatter->asCurrency($totalCredits));;
		$minCashout = str_ireplace('USD', '$', Yii::$app->formatter->asCurrency(Yii::$app->params['minimum_member_cashout']));;
		Yii::trace($cashoutType);
        Yii::trace($tabOptions);        
		$viewParams = [
			'totalCredits' => $totalCredits,
            'totalCreditsValue' => $totalCreditsValue,
			'totalPoints' => $totalPoints, 
			'minCashout' => $minCashout,
            'schoolDonationForm' => $schoolDonationForm,
            'tabOptions' => $tabOptions,
		];
		
        return $this->render('cashOut', $viewParams);
    }
    
    public function actionSendConfirmationEmail()
    {
        $confirmDetails = Yii::$app->iglobalApi->getConfirmCode(Yii::$app->user->identity->id);
        if($confirmDetails['confirmCode'])
        {
            Yii::$app->mailer->compose('memberConfirm', [
            'memberId' => Yii::$app->user->identity->id,
            'userName' => Yii::$app->user->identity->firstName,
            'confirmCode' => $confirmDetails['confirmCode']
            ])
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
            ->setTo(Yii::$app->user->identity->email)
            ->setSubject(\Yii::$app->name . ' email confirmation.')
            ->send();

            Yii::$app->session->setFlash('success', "We just sent the confirmation email again to your email address. If you do not see the email, please check your spam/bulk folder.<br/>
			<br/>
			If the message does not show up and you can't click on the link in the email to confirm, please <a href=\"".Yii::$app->urlManager->createUrl('dashboard/support')."\">contact us</a>.");
        }
        else
        {
            Yii::$app->session->setFlash('danger', $confirmDetails['errors']);
        }
        return $this->redirect('/dashboard');
    }
    
    public function actionStartSurvey($invitationId)
    {
        $fields = [
            'memberId' => Yii::$app->user->identity->id,
            'cintInvitationId' => $invitationId
        ];
        
        if($result = Yii::$app->iglobalApi->startSurvey($fields))
        {
            return $this->redirect($result['surveyLink']);
        }
    }
    
    public function actionAjaxSurveyNextButton()
    {
        // accept only AJAX requests
		if (!Yii::$app->request->isAjax) 
		{
            exit();
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $sId = Yii::$app->session['sId'];
        $postData = Yii::$app->request->post();
        
        if($postData['profileId'])
        {
            $profileId = $postData['profileId'];
            $memberId = Yii::$app->user->identity->id;
            if($sId && $postData['memberData'])
            {
                $surveyData = Yii::$app->iglobalApi->profileNextQuestion($memberId, $profileId, $sId, $postData['memberData']);
            }
            else
            {
                $surveyData = Yii::$app->iglobalApi->profileNextQuestion($memberId, $profileId);
            }            
        }
        
        if($surveyData['sId'])
        {
            Yii::$app->session['sId'] = $surveyData['sId'];
        }
 
        return $surveyData;
    }
    
    public function actionAjaxSurveyPreviousButton()
    {
        // accept only AJAX requests
		if (!Yii::$app->request->isAjax) 
		{
            exit();
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $sId = Yii::$app->session['sId'];
        $postData = Yii::$app->request->post();
        
        if($postData['profileId'])
        {
            $profileId = $postData['profileId'];
            $memberId = Yii::$app->user->identity->id;
            if($sId)
            {
                $surveyData = Yii::$app->iglobalApi->profilePreviousQuestion($memberId, $profileId, $sId);
            }            
        }
        
        if(isset($surveyData['sId']))
        {
            Yii::$app->session['sId'] = $surveyData['sId'];
        }
 
        return $surveyData;
    }
    
    public function actionAjaxSurveyStartOver()
    {
        // accept only AJAX requests
		if (!Yii::$app->request->isAjax) 
		{
            exit();
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $sId = Yii::$app->session['sId'];
        $postData = Yii::$app->request->post();
        
        if($postData['profileId'])
        {
            $profileId = $postData['profileId'];
            $memberId = Yii::$app->user->identity->id;
            if($sId)
            {
                $surveyData = Yii::$app->iglobalApi->profileStartOver($memberId, $profileId, $sId);
            }            
        }
        
        if(isset($surveyData['sId']))
        {
            Yii::$app->session['sId'] = $surveyData['sId'];
        }
 
        return $surveyData;
    }
    
    public function actionAjaxLoadMemberTransactions()
    {
        // accept only AJAX requests
		if (!Yii::$app->request->isAjax) 
		{
            exit();
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $memberTxns = Yii::$app->iglobalApi->getMemberTransactions(Yii::$app->user->identity->id);
        $txns = [];
        $totalCredits = 0;
		$totalPoints = 0;

		foreach($memberTxns as &$transaction)
		{
			if($transaction['cintTransactionTypeKey'] == 'tt_pay')
			{
				$totalCredits -= $transaction['cintMemberTransactionAmount'];		
			}
			else
			{
				$totalCredits += $transaction['cintMemberTransactionAmount'];		
			}
			$txn = [
				Yii::$app->formatter->asDate($transaction['cintMemberTransactionDate']),
				$transaction['cintTransactionTypeName'],
				$transaction['cintMemberTransactionAmount']*100,
				str_ireplace('USD', '$', Yii::$app->formatter->asCurrency($transaction['cintMemberTransactionAmount']))				
			];
			$txns[] = $txn;
		}
		
		$totalCredits = round($totalCredits, 3);
		$totalPoints = ($totalCredits)?$totalCredits*100:0;

		$totalCredits = str_ireplace('USD', '$', Yii::$app->formatter->asCurrency($totalCredits));
		return [
			'headers' => [
				'Date',
				'Type',
				'Points',
				'Amount'
				],
			'rows' => $txns,
			'totalCredits' => $totalCredits,
			'totalPoints' => $totalPoints
		];        
    }
    
    public function actionAjaxLoadMemberInvites()
    {
         // accept only AJAX requests
		if (!Yii::$app->request->isAjax) 
		{
            exit();
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $memberInvites = Yii::$app->iglobalApi->getMemberSurveyInvitations(Yii::$app->user->identity->id);
        
        $invites = [];
        if($memberInvites && count($memberInvites) > 0)
        {
            foreach($memberInvites as $mi)
            {
                $invites[] = [
                    [
                        'type' => 'link',
                        'href' => "/dashboard/start-survey/".$mi["cintInvitationId"],
                        'text' => $mi["cintInvitationSurveyUrl"]
                    ],
                    //\yii\helpers\Html::a($mi["cintInvitationSurveyUrl"], "/dashboard/start-survey/".$mi["cintInvitationId"], ["target" => "_blank"]),
                    "$ {$mi['cintInvitationIncentiveAmount']}",
                    "{$mi['cintInvitationLoi']} Minutes",
                    "{$mi['cintInvitationProjectId']}",
                ];                
            }
        }
        
        return [
            'headers' => [
                'Survey URL',
                'Incentive',
                'Est. Length',
                'Project ID'
            ],
            'rows' => $invites,
        ];        
    }
	
	public function actionSchoolDonationSelect()
	{
		$this->layout = 'column1';
		$schoolDonationForm = new SchoolDonationForm(['schoolDonationTypes' => [
            1 => "I don't want to select a specific school, but want to support schools in my area.",
            2 => "I want to select a specific school to support"
        ]]);
		
		if(Yii::$app->request->post())
		{
			$schoolDonationForm->load(Yii::$app->request->post());
			if($schoolDonationForm->validate())
			{
				$cashOutChoice = CashOutChoice::findOne(['memberId' => Yii::$app->user->identity->id]);
				if(!$cashOutChoice)
				{
					$cashOutChoice = new CashOutChoice();
					$cashOutChoice->memberId = Yii::$app->user->identity->id;	
				}
				$cashOutChoice->cashOutType = 2;
				$cashOutChoice->schoolDonationType = $schoolDonationForm->schoolDonationType;
				$cashOutChoice->schoolId = $schoolDonationForm->schoolId;
				$cashOutChoice->schoolName = $schoolDonationForm->schoolName;
				$cashOutChoice->save();
				
				if(!$cashOutChoice->hasErrors())
				{
					return $this->redirect('/dashboard');
				}
			}
		}
		
		return $this->render('schoolDonationSelect',[
			'schoolDonationForm' => $schoolDonationForm,
			'cashoutType' => 2,
			'totalCreditsValue' => 0,
		]);
	}
    
    private function loadDefaultCashout()
    {
        $defaults = [
            'schoolDonationType' => 2,            
        ];
		
		$cashOutChoice = CashOutChoice::findOne(['memberId' => Yii::$app->user->identity->id]);
		if($cashOutChoice)
		{
			$defaults['schoolDonationType'] = $cashOutChoice->schoolDonationType;
			$defaults['schoolId'] = $cashOutChoice->schoolId;
			$defaults['schoolName'] = $cashOutChoice->schoolName;
		}
        
        return $defaults;
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
}
