<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "CashOutChoice".
 *
 * @property integer $cashOutChoiceId
 * @property string $dateCreated
 * @property string $dateLastModified
 * @property integer $cashOutType
 * @property integer $schoolDonationPercentage
 * @property integer $schoolDonationType
 * @property integer $schoolId
 * @property string $schoolName
 * @property integer $memberId
 */
class CashOutChoice extends \common\components\CustomActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CashOutChoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateCreated', 'dateLastModified'], 'safe'],
            [['cashOutType', 'schoolDonationPercentage', 'schoolDonationType', 'schoolId', 'memberId'], 'integer'],
            [['schoolName'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cashOutChoiceId' => 'Cash Out Choice ID',
            'dateCreated' => 'Date Created',
            'dateLastModified' => 'Date Last Modified',
            'cashOutType' => 'Cash Out Type',
            'schoolDonationPercentage' => 'School Donation Percentage',
            'schoolDonationType' => 'School Donation Type',
            'schoolId' => 'School ID',
            'schoolName' => 'School Name',
            'memberId' => 'Member ID',
        ];
    }
}
