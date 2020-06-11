<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class TypeFile
 * @package backend\modules\base\models\Entity
 * @property $id
 * @property $name
 */
class TypeFile extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%dic_type_file}}';
    }

    //справочник форматов
    public static function GetTypeList()
    {
        return self::find()->all();
    }

    //поиск тегов по id
    public static function findTypeById($id)
    {
        return static::findOne(['id' => $id]);
    }

    //поиск тегов по имени
    public static function findTypeByName($name)
    {
        return static::findOne(['name' => $name]);
    }
}

