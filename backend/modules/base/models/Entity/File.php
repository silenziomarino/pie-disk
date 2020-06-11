<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class File
 * @package backend\modules\base\models\Entity
 * @property $id
 * @property $name
 * @property $binary
 * @property $extension
 * @property $size
 * @property $mime
 * @property $date
 * @property $updated_at
 * @property $user_create_id
 * @property $trash
 */
class File extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%file}}';
    }

    public static function findFile($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function GetFileList()
    {
        return self::find()->all();
    }
}

