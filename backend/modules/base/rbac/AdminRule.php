<?php

namespace backend\modules\base\rbac;

use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\User;
use yii\rbac\Rule;

/**
 * Class AdminRule
 * @package backend\modules\base\rbac
 */
class AdminRule extends Rule
{
    public $name = 'isAdmin'; // Имя правила

    public function execute($user_id, $item, $params)
    {
        $role = AuthAssignment::GetUserRole($user_id);
        if($role->item_name == 'admin')return true;//доступ для админа
        return false;
    }
}