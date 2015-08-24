<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "UserStatus".
 *
 * @property integer $userStatusId
 * @property string $dateCreated
 * @property string $dateLastModified
 *
 * @property User[] $users
 */
class UserStatus extends \common\components\CustomActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UserStatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateCreated', 'dateLastModified'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userStatusId' => 'User Status ID',
            'dateCreated' => 'Date Created',
            'dateLastModified' => 'Date Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['userStatusId' => 'userStatusId']);
    }
}
