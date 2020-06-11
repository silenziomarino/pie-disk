<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class AuthAssignment
 * @package backend\modules\base\models\Entity
 */
class AuthAssignment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_assignment}}';
    }

    //список
    public function GetAuthAssignmentList()
    {
        return self::find()->all();
    }

    //получаем запись по id пользователя
    public static function GetUserRole($user_id)
    {
        return self::findOne(['user_id' => $user_id]);
    }
}

