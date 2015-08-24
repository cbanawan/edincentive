<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "UserType".
 *
 * @property integer $userTypeId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property string $userTypeName
 *
 * @property User[] $users
 */
class UserType extends \common\components\CustomActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UserType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateCreated', 'dateLastModified'], 'safe'],
            [['userTypeName'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userTypeId' => 'User Type ID',
            'dateCreated' => 'Date Created',
            'dateLastModified' => 'Date Last Modified',
            'userTypeName' => 'User Type Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['userTypeId' => 'userTypeId']);
    }
}
