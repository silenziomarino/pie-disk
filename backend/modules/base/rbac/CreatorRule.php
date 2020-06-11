<?php

namespace backend\modules\base\rbac;

use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\User;
use yii\rbac\Rule;

/**
 * правило доступа где редактировать файлы могут только авторы и admin
 * Class CreatorRule
 * @package backend\modules\base\rbac
 */
class CreatorRule extends Rule
{
    public $name = 'isCreator'; // Имя правила

    public function execute($user_id, $item, $params)
    {
        $role = AuthAssignment::GetUserRole($user_id);
        if($role->item_name == 'admin')return true;//доступ для админа

        return isset($params['file']) ? $params['file']->user_create_id == $user_id : false;
    }
}