<?php
namespace frontend\models;

use common\models\identities\Panelist;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $passwordConfirm;
    public $currentPassword;
    public $requireOldPassword = false;
    
    /**
     * @var common\models\identities\Panelist
     */
    private $_user;
 
    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($user, $config = [])
    {
        if (empty($user) || !($user instanceof Panelist)) {
            throw new InvalidParamException('User must be an instance of common\models\identities\User and cannot be empty.');
        }
        $this->_user = $user;
        
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'passwordConfirm'], 'required'],
            ['password', 'string', 'min' => 6],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Password and Password Confirm must match exactly.'],
			[['currentPassword', 'password', 'passwordConfirm'], 'safe'],
        ];
    }
    
    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $result = Yii::$app->iglobalApi->passwordReset(['memberId' => $user->id, 'oldPassword' => $this->currentPassword, 'newPassword' => $this->password]);
        if($result['errors'])
		{
            if($result['errors']['password'])
            {
                $result['errors']['currentPassword'] = $result['errors']['password'];
            }
			$this->addErrors($result['errors']);
		}
    }
}
