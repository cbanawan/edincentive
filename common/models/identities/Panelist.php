<?php
namespace common\models\identities;

use Yii;
use yii\base\Component;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\base\Event;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property string $password write-only password
 */
class Panelist extends Component implements IdentityInterface
{
	public $id;
	public $email;
    public $firstName;
    public $lastName;
    public $statusId;
	protected $auth_key;
	protected $role;
		
	public function __construct($config = [])
	{
		parent::__construct($config);
	}
	
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $panelist = null;
        if(Yii::$app->session['identity'] && Yii::$app->session['identity']->id == $id)
        {
            $panelist = Yii::$app->session['identity'];
        }
        else
        {
            $memberData = Yii::$app->iglobalApi->getMember($id);
            if(!empty($memberData))
            {
                $panelist = new Panelist(['id' => $id]);
                $panelist->email = $memberData['memberEmail'];
                $panelist->firstName = $memberData['firstName'];
                $panelist->lastName = $memberData['lastName'];
                $panelist->statusId = $memberData['memberStatusId'];
                Yii::trace($memberData);
            }
            Yii::$app->session['identity'] = $panelist;
        }       
        		      
		return $panelist;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        throw new NotSupportedException('"findByUsername" is not implemented.');
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        throw new NotSupportedException('"findByPasswordResetToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return array
     */
    public function validatePassword($password)
    {
		return Yii::$app->iglobalApi->login(['email' => $this->email, 'password' => $password]);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
         throw new NotSupportedException('"removePasswordResetToken" is not implemented.');
    }
}
