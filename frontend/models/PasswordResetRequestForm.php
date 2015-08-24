<?php
namespace frontend\models;

use Yii;
use common\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],            
        ];
    }
    
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $result = Yii::$app->iglobalApi->requestPasswordReset([
            'email' => $this->email,
        ]);
        Yii::trace($result);
        if($result['memberId'] && $result['firstName'])
        {
            return Yii::$app->mailer->compose('passwordReset', [
						'memberId' => $result['memberId'],
						'userName' => $result['firstName'],
						'confirmCode' => $result['confirmCode']
						])
                        ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                        ->setTo($this->email)
                        ->setSubject(\Yii::$app->name . ' password reset request.')
                        ->send();
        }
        else
        {
            $this->addErrors($result['errors']);
        }
        return false;
    }
}
