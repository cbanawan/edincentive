<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "SiteSession".
 *
 * @property string $id
 * @property integer $expire
 * @property resource $data
 */
class SiteSession extends \common\components\CustomActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SiteSession';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['expire'], 'integer'],
            [['data'], 'string'],
            [['id'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expire' => 'Expire',
            'data' => 'Data',
        ];
    }
}
