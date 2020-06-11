<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\AuthItem;
use backend\modules\base\models\Entity\AuthItemChild;
use yii\base\Model;
use yii\db\Query;

/**
 * Class AuthItemModel
 * @package backend\modules\base\models
 */
class AuthItemModel extends Model
{
    public static $dic = [];

    public static function GetAuthItem($auth_item)
    {
        return AuthItem::findOne(['name' => $auth_item]);
    }
    //список всех доступов
    public function GetList()
    {
        return AuthItem::find()->all();
    }

    //справочник ролей для текущей роли
    public static function GetDicAuthItem()
    {
        //список ролей
        $list = self::GetChild();

        $query = new Query();
        $data = $query->select([
            'name AS id',
            "description AS name",
        ])
            ->from('auth_item')
            ->andFilterWhere(['in','name',$list])
            ->all();
        return $data;
    }

    //получаем список ролей не выше чем у текущего пользователя
    public static function GetChild($role = null)
    {
        if(!$role) {
            $role = AuthAssignment::GetUserRole(\Yii::$app->user->getId());
            self::$dic[] = $role['item_name'];
        }
        $children = AuthItemChild::GetChild($role);
        foreach ($children as $value){
            if(self::isRole($value['child'])){
                $role = $value['child'];
                self::$dic[] = $role;
                self::GetChild($role);
            }
        }
        return self::$dic;
    }

    //проверка типа записи, если роль тогда true
    public static function isRole($item)
    {
        $data = AuthItem::find()
            ->andFilterWhere(['name' => $item])
            ->andFilterWhere(['type' => '1'])
            ->all();
        if(!empty($data)) return true;
        else return false;
    }
}
