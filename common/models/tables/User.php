<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property integer $userId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $userName
 * @property string $userEmail
 * @property string $userPassword
 * @property integer $userTypeId
 * @property integer $userStatusId
 * @property integer $userIglobalMemberId
 *
 * @property UserType $userType
 * @property UserStatus $userStatus
 * @property UserConfirmation[] $userConfirmations
 */
class User extends \common\components\CustomActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateCreated', 'dateLastModified'], 'safe'],
            [['userTypeId', 'userStatusId'], 'required'],
            [['userTypeId', 'userStatusId', 'userIglobalMemberId'], 'integer'],
            [['userName', 'userEmail', 'userPassword'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'dateCreated' => 'Date Created',
            'dateLastModified' => 'Date Last Modified',
            'userName' => 'User Name',
            'userEmail' => 'User Email',
            'userPassword' => 'User Password',
            'userTypeId' => 'User Type ID',
            'userStatusId' => 'User Status ID',
            'userIglobalMemberId' => 'User Iglobal Member ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['userTypeId' => 'userTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserStatus()
    {
        return $this->hasOne(UserStatus::className(), ['userStatusId' => 'userStatusId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserConfirmations()
    {
        return $this->hasMany(UserConfirmation::className(), ['userId' => 'userId']);
    }
    
    public function beforeSave($insert)
    {
        if(self::isAttributeChanged('userPassword'))
        {
            $this->userPassword = Yii::$app->security->generatePasswordHash($this->userPassword);
        }
        return parent::beforeSave($insert);
    }
}
