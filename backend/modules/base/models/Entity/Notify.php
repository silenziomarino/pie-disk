<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Notify
 * @package backend\modules\base\models\Entity
 * @property integer $id
 * @property Json $params
 * @property string $view
 * @property integer $user_id
 */
class Notify extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%notify}}';
    }

    public static function GetNotify($user_id,$count = 5)
    {
        return self::find(['user_id' => $user_id])
            ->orderBy('id desc')
            ->offset(0)
            ->limit($count)
            ->all();
    }

    //получить список уведомлений по пользователю и виду уведомления
    public static function GetNotifyByViewAndUSerId($user_id,$view)
    {
        return self::find([
            'user_id' => $user_id,
            'view' => $view,
        ])
            ->orderBy('id desc')
            ->all();
    }

    public static function GetCountNotify($id)
    {
        return self::find(['user_id' => $id])->count();
    }
}

