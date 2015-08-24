<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\tables\Question;

class ChangeEmailForm extends Model
{
	public $email;
	private $_member;
	
	public function __construct($member, $config = array())
	{
		$this->_member = $member;
		parent::__construct($config);
	}

	public function rules()
	{
		return array(
			['email', 'required'],
			['email', 'email'],			
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'email' => 'New Email',
		);
	}
	
	public function saveEmail()
	{
		// Save member's new email address for validation
        return Yii::$app->iglobalApi->changeEmail(['memberId' => $this->_member->id, 'newEmail' => $this->email]);
    }
}
