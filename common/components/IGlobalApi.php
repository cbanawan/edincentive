<?php
namespace common\components;

use Yii;
use yii\web\JsonParser;

class IGlobalApi extends \yii\base\Component
{
    public $panelKey;
    public $panelSecret;
    public $apiUrl;
	public $resourceId;
    
    public function signup($fields)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/create', 'POST', json_encode($fields), ['Content-Type: application/json']);
    }
    
    public function confirm($fields)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/confirm', 'POST', json_encode($fields), ['Content-Type: application/json'], 30.5);
    }
	
	public function login($fields)
	{
		return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/login', 'POST', json_encode($fields), ['Content-Type: application/json']);
	}
    
    public function passwordReset($fields)
	{
		return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/password-reset', 'POST', json_encode($fields), ['Content-Type: application/json']);
	}
    
    public function changeEmail($fields)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/change-email', 'POST', json_encode($fields), ['Content-Type: application/json']);
    }
    
    public function requestPasswordReset($fields)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/request-password-reset', 'POST', json_encode($fields), ['Content-Type: application/json']);
    }
    
    public function getMember($memberId)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/members/'.$memberId);
    }
    
    public function getMemberTransactions($memberId)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/transactions/'.$memberId);
    }
	
	public function unsubscribe($memberId)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/unsubscribe/'.$memberId);
    }
    
    public function getMemberProfiles($memberId)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/profile/get-member-profiles/'.$memberId);
    }
    
    public function getMemberSurveyInvitations($memberId)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/invitations/'.$memberId);
    }
    
    public function startSurvey($fields)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/start-survey', 'POST', json_encode($fields), ['Content-Type: application/json']);
    }
    
    public function cashOut($memberId, $paymentDetails)
    {
        $fields = $paymentDetails;
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/cash-out/'.$memberId, 'POST', json_encode($fields), ['Content-Type: application/json']);
    }
    
    public function getConfirmCode($memberId)
    {
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/member/get-confirm-code/'.$memberId, 'POST', json_encode([]), ['Content-Type: application/json']);
    }
    
    public function getLatestProfile($memberId)
    {
        $profiles = $this->getMemberProfiles($memberId);
        Yii::trace($profiles);
        foreach($profiles as $profile)
        {
            if($profile['profileStatusId'] != 3)
            {
                return $profile['profileId'];
            }
        }
        return false;
    }
    
    public function profileNextQuestion($memberId, $profileId, $sId = null, $memberData = null)
    {
        $postData = [
            'memberId' => $memberId,
            'profileId' => $profileId
        ];
        
        if($sId)
        {
            $postData['sId'] = $sId;
        }
        
        if($memberData)
        {
            $postData['memberData'] = $memberData;
        }
        
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/profile/next-question', 'POST', json_encode($postData), ['Content-Type: application/json']);
    }
    
    public function profilePreviousQuestion($memberId, $profileId, $sId)
    {
        $postData = [
            'memberId' => $memberId,
            'profileId' => $profileId,
            'sId' => $sId
        ];
        
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/profile/previous-question', 'POST', json_encode($postData), ['Content-Type: application/json']);
    }
    
    public function profileStartOver($memberId, $profileId, $sId)
    {
        $postData = [
            'memberId' => $memberId,
            'profileId' => $profileId,
            'sId' => $sId
        ];
        
        return $this->urlFetch($this->apiUrl.'/'.$this->resourceId.'/profile/start-over', 'POST', json_encode($postData), ['Content-Type: application/json']);
    }
    
    public function searchSchools($params)
    {
        $targetUrl = array_merge(['/'.$this->resourceId.'/schools/search'],$params);
        $targetUrl = $this->apiUrl . Yii::$app->urlManager->createUrl($targetUrl);
        return $this->urlFetch($targetUrl);
    }
    
    public function getSchoolStats($schoolId)
    {
        $targetUrl = array_merge(['/'.$this->resourceId.'/school/get-stats'], [ 'schoolId' => $schoolId ]);
        $targetUrl = $this->apiUrl . Yii::$app->urlManager->createUrl($targetUrl);
        return $this->urlFetch($targetUrl);
    }
    
    private function urlFetch($url, $method = 'GET', $data = '', $addlHeaders = array(), $timeout = 60)
    {
        $header = "Authorization: Basic " . base64_encode($this->panelSecret . ':' . $this->panelKey ) . "\r\n";
        $header .= "Accept: application/json\r\n";

        if (!empty($addlHeaders))
        {
            $header .= implode("\r\n", $addlHeaders);
            $header .= "\r\n";
        }

        if (!empty($data))
        {
            $context["http"]["content"] = $data;
            $header .= "Content-Length:" . strlen($data) . "\r\n";
        }

        $context["http"]["method"] = $method;
        $context["http"]["follow_location"] = 0;
        $context["http"]["header"] = $header;
        $context["http"]["timeout"] = $timeout;
        $context["http"]["ignore_errors"] = true; //fetch content even on failure status codes
        $context["ssl"]["verify_peer"] = false;
        
        $context = stream_context_create($context);
		$result  = @file_get_contents($url, false, $context);
        Yii::trace($result);
        if($result)
        {
            $parser = new JsonParser();
            $result = $parser->parse($result, 'application/json');
        }
        
        return $result;
    }
}
