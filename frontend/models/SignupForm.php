<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\identities\WebUser;
use common\components\IGlobalAPI;

class SignupForm extends Model
{
	public $email;
	public $firstName;
	public $lastName;
	public $password;
	public $gender;
	public $postal;
	public $yearOfBirth;
    private $_memberId;
    
    public function getMemberId()
    {
        return $this->_memberId;
    }
		
	public function rules()
	{
		return [
			[['email', 'gender', 'postal', 'yearOfBirth', 'password', 'firstName', 'lastName'],'required'],
            [['email', 'firstName', 'lastName'], 'filter', 'filter'=>'trim'],
			['email','email'],
			['yearOfBirth', 'ageCheck'],
			['postal', 'match', 'pattern' => "/^\d{5}$/", 'message' => "Zip code must be 5 digit format."],
			['password', 'passwordCheck'],			
		];
	}
	
	public function ageCheck($attribute, $params)
	{
		// must be 18 years old to sign up
		$currentYear = date('Y');
		
		if($currentYear - $this->$attribute < 18)
		{
			$this->addError($attribute, 'Must be 18 years or older to sign up.');
		}		
	}
	
	public function passwordCheck()
	{
		if(strlen($this->password) < 8 )
		{
			$this->addError('password', 'Password must be at least 8 characters.');
		}
	}
	
	public function attributeLabels() 
	{
		return array(
			'postal' => 'Zip Code',			
		);
	}
    
    public function join()
    {
		//use IGlobal API call here
        $api = Yii::$app->iglobalApi;
        $result = $api->signup($this->attributes);
        
        if($result['errors'])
        {
            $this->addErrors($result['errors']);
        }
        
        return $result;
    }
}