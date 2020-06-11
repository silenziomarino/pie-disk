<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class AuthItemChild
 * @package backend\modules\base\models\Entity
 */
class AuthItemChild extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_item_child}}';
    }

    //список всех записей
    public static function GetList()
    {
        return self::find()->all();
    }

    //список всех записей
    public static function GetChild($role)
    {
        return self::find()
            ->select(['child'])
            ->andFilterWhere(['parent' => $role])
            ->all();
    }
}

