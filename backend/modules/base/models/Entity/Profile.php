<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * Class Profile
 * @package backend\modules\base\models\Entity
 * @property integer $id
 * @property integer $user_id
 * @property string  $first_name
 * @property string  $last_name
 * @property string  $middle_name
 * @property null    $photo
 * @property string auth_item_name
 */
class Profile extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%profile}}';
    }

    //справочник профилей
    public function GetDicProfile()
    {
        $query = new Query();
        $data = $query->select([
                'user_id as id',
                "CONCAT(last_name, ' ', first_name) AS name",
            ])
            ->from('profile')
            ->all();
        return $data;
    }
    //профили всех пользователей
    public function GetProfileList()
    {
        return self::find()->all();
    }

    public static function GetProfile($user_id)
    {
        return self::findOne(['user_id' => $user_id]);
    }

    //возвращает список ФИО в котором  есть искомое значение(не больше 10)
    public static function GetFioLikeName($name)
    {
        $query = new Query();
        $data = $query->select([
            'user_id as id',
            "CONCAT(last_name, ' ', first_name, ' ', middle_name) AS name",
        ])
            ->from('profile')
            ->orFilterWhere(['ilike', 'first_name', $name])
            ->orFilterWhere(['ilike', 'last_name', $name])
            ->orFilterWhere(['ilike', 'middle_name', $name])
            ->offset(0)
            ->limit(10)
            ->all();
        return $data;
    }
}

