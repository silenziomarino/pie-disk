<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * Class Teg
 * @package backend\modules\base\models\Entity
 * @property $id
 * @property $name
 */
class Teg extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%dic_teg}}';
    }

    //поиск тегов по id
    public static function findTegById($id)
    {
        return static::findOne(['id' => $id]);
    }

    //поиск тегов по имени
    public static function findTegByName($name)
    {
        return static::findOne(['name' => $name]);
    }

    //справочник тегов
    public static function GetTegList()
    {
        return self::find()->all();
    }
    //запрос
    public static function GetQuery()
    {
        return self::find();
    }

    //возвращает список тего по имени (не больше 10)
    public static function GetTegLikeName($name)
    {
        return self::find()
            ->andFilterWhere(['ilike', 'name', $name])
            ->offset(0)
            ->limit(10)
            ->all();
    }
}

