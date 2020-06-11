<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\Profile;
use backend\modules\base\models\Entity\User;
use Yii;
use yii\base\Model;

class UserModel extends Model
{
    //удаление пользователя
    public static function deleteUser($id)
    {
        if (empty($id)) return false;
        if(Yii::$app->user->getId() == $id) return false;

        $profile = Profile::GetProfile($id);
        $puth = \Yii::getAlias('@backend') . '/web';

        //удаляем аватарку
        $file_puth = $puth . $profile->photo;
        if(file_exists($file_puth)) unlink($file_puth);
        //удаляем роль
        AuthAssignment::GetUserRole($id)->delete();
        //удаляем записи пользователя из таблиц
        User::findIdentity($id)->delete();

        return true;
    }

    //добавление/удаление пользователя в черны список
    public static function lockUser($user_id, $status)
    {
        if (empty($user_id)) return false;
        if(Yii::$app->user->getId() == $user_id) return false;

        $model = User::findOne($user_id);
        $model->lock = $status;
        if($model->save())return true;
        else return false;
    }
}
