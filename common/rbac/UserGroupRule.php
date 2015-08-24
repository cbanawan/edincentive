<?php

namespace common\rbac;

use Yii;
use yii\rbac\Rule;
use common\models\identities\WebUser;
use common\models\identities\AdminUser;
use common\models\identities\Panelist;

/**
 * Checks if user group matches
 */
class UserGroupRule extends Rule
{

    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
		\Yii::trace(Yii::$app->user->identity instanceOf Panelist);
		\Yii::trace($item->name);
        switch ($item->name)
        {
            case('panelist'):                   
                return Yii::$app->user->identity instanceOf Panelist;
                break;
            case('adminUser'):
                return Yii::$app->user->identity instanceOf AdminUser;
                break;
        }
        
        return false;
    }

}
