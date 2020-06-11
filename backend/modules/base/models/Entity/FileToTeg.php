<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;

class FileToTeg extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%file_to_teg}}';
    }

    public function rules()
    {
        return [];
    }

    //поиск записи по id
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    //получаем все записи где file_id
    public static function findRowsByFileId($file_id)
    {
        return FileToTeg::find()
            ->where([
                'file_id' => $file_id,
            ])->all();
    }

    //получаем все записи где teg_id
    public static function findRowsByTegId($teg_id)
    {
        return FileToTeg::find()
            ->where([
                'teg_id' => $teg_id,
            ])->all();
    }

    //поиск записи по тегу и файлу
    public static function findFileToTeg($file_id,$teg_id)
    {
        return static::findOne([
            'file_id' => $file_id,
            'teg_id'  => $teg_id,
        ]);
    }
}

