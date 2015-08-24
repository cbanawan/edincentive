<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "UserConfirmation".
 *
 * @property integer $userConfirmationId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $userConfirmationcCode
 * @property integer $userId
 *
 * @property User $user
 */
class UserConfirmation extends \common\components\CustomActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UserConfirmation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateCreated', 'dateLastModified'], 'safe'],
            [['userId'], 'required'],
            [['userId'], 'integer'],
            [['userConfirmationcCode'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userConfirmationId' => 'User Confirmation ID',
            'dateCreated' => 'Date Created',
            'dateLastModified' => 'Date Last Modified',
            'userConfirmationcCode' => 'User Confirmationc Code',
            'userId' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }
}
