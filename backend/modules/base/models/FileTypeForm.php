<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\TypeFile;
use yii\base\Model;

class FileTypeForm extends Model
{
    public $str;

    public function rules()
    {
        return [
            ['str', 'string'],
        ];
    }

    public function update()
    {
        //очищаем таблицу
        TypeFile::deleteAll();
        //добавляем новые типы для файла
        $array_type = explode(",", $this->str);
        foreach ($array_type as $key => $value) {
            $name = trim($value);
            if ($name == '') continue;
            $name = quotemeta($name);
            $name = mb_strtolower($name);
            $name = preg_replace("/[^\.a-zа-яё0-9- ]/iu", '', $name);

            $TypeFile = new TypeFile();
            $TypeFile->name = $name;
            $TypeFile->save();
        }
    }

}
