<?php

namespace backend\modules\base\rbac;

use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\Notify;
use backend\modules\base\models\Entity\User;
use yii\rbac\Rule;

/**
 * правило доступа на подтверждение регистрации новых пользователей
 * Class InviterRule
 * @package backend\modules\base\rbac
 */
class InviterRule extends Rule
{
    public $name = 'isInviter'; // Имя правила

    /**
     * @param int|string $user_id
     * @param \yii\rbac\Item $item
     * @param array $params
     * @return bool
     *
     * метод получает запись из табл уведомлений где ид $user_id и проверяет все его уведомления
     * если среди них есть запись с $invited_id тогда можно подвердить регистрацию
     * иначе не может
     */
    public function execute($user_id, $item, $params)
    {
        $role = AuthAssignment::GetUserRole($user_id);
        if($role->item_name == 'admin')return true;//доступ для админа

        $invited_id = $params['invited_id'];
        $notify = Notify::GetNotify($user_id);
        foreach ($notify as $item){
            if($item->view != 'auth')continue;
            $params = json_decode($item->params,true);
            if($invited_id == $params['invited']){
                $role = AuthAssignment::GetUserRole($user_id);
                if($role->item_name == 'moderator')return true;
            }
        }
        return false;
    }
}