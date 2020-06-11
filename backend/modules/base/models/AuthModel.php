<?php

namespace backend\modules\base\models;

use yii\base\Model;
use yii\db\Query;

class AuthModel extends Model
{
    //список пользователей которые смогут подтвердить регистрацию
    public static function GetListUserWithBigRole()
    {
        $query = new Query();
        $user_list = $query->select([
            "p.user_id AS id",
            "CONCAT(p.last_name, ' ', p.first_name, ' ', p.middle_name) AS user",
        ])
            ->from(['auth_assignment aa'])
            ->join('LEFT JOIN', 'profile p', 'p.user_id::integer = aa.user_id::integer')
            ->orFilterWhere(['aa.item_name' => 'moderator'])
            ->orFilterWhere(['aa.item_name' => 'admin'])
            ->groupBy('p.id')
            ->all();

        $u_list = [];
        foreach ($user_list as $key => $value){
            $u_list[ $value['id'] ] = $value['user'];
        }
        return $u_list;
    }
}
