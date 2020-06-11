<?php

namespace backend\modules\base\rbac;

use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\Notify;
use backend\modules\base\models\Entity\User;
use yii\rbac\Rule;

/**
 * Праверка на модератора
 * Class ModeratorRule
 * @package backend\modules\base\rbac
 */
class ModeratorRule extends Rule
{
    public $name = 'isModerator'; // Имя правила

    public function execute($user_id, $item, $params)
    {
        $role = AuthAssignment::GetUserRole($user_id);
        if($role->item_name == 'admin')return true;//доступ для админа

        $role = AuthAssignment::GetUserRole($user_id);
        if($role->item_name == 'moderator')return true;
        return false;
    }
}