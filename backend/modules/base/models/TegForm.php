<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\FileToTeg;
use backend\modules\base\models\Entity\Teg;
use yii\base\Model;

/**
 * Class TegForm
 * @package backend\modules\base\models
 * @property integer $id  id файла
 * @property string $str  строка тегов (через запятую)
 */
class TegForm extends Model
{
    public $id;
    public $str;

    public function rules()
    {

        return [
            ['id', 'default'],
            ['str', 'string'],
        ];
    }

    public function update(){
        //добавляем новые теги для файла
        $array_teg = explode(",", $this->str);
        foreach ($array_teg as $teg_key => $teg_value) {
            $name = trim($teg_value);
            if($name == '')continue;
            $name = quotemeta($name);
            $name = mb_strtolower($name);
            $name = preg_replace("/[^\.a-zа-яё0-9- ]/iu", '', $name);
            $teg = Teg::findTegByName($name);
            if (empty($teg)) {
                $teg = new Teg();
                $teg->name = $name;
                $teg->save();
            }

            $record = FileToTeg::findFileToTeg($this->id, $teg->id);
            if (empty($record)) {
                $record = new FileToTeg();
                $record->file_id = $this->id;
                $record->teg_id = $teg->id;
                $record->save();
            }
        }
        return true;
    }

}
