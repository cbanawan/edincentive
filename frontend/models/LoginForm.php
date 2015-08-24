<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\identities\Panelist;
use yii\base\Event;

/**
 * Login form
 */
class LoginForm extends Model
{

    public $email;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],            
            // handle user status
            ['email', 'handleStatus']
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
        {
			$user = $this->getUser();
			$result = $user->validatePassword($this->password);
			if (!$result || isset($result['errors']))
            {
                $this->addErrors($result['errors']);
                $this->addError('password', 'Incorrect username or password.');
                return false;
            }
            
            $user->id = $result['memberId'];
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else
        {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        $this->_user = new Panelist(['email' => $this->email]);

        return $this->_user;
    }
    
    public function handleStatus()
    {
        // Handle Admin user status here        
    }
}
