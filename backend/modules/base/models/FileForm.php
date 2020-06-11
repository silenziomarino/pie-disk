<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\File;
use backend\modules\base\models\Entity\FileHistory;
use backend\modules\helpers\file\FileHelpers;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * модель формы добавления файлов
 * Class FileForm
 * @package backend\modules\base\models
 * @property $id
 * @property $name
 * @property $files
 */
class FileForm extends Model
{
    public $id;
    public $name;
    /** @var UploadedFile[] */
    public $files;

    const FILE_CREATE = 'file_create';
    const FILE_UPDATE = 'file_update';

    public function scenarios()
    {
        return [
            self::FILE_CREATE => [
                'files',
            ],
            self::FILE_UPDATE => [
                'id',
                'name',
            ],
        ];
    }

    public function rules()
    {
        $upload_max_filesize = ini_get('upload_max_filesize');
        $max_file_size = FileHelpers::ReturnBytes($upload_max_filesize);
        $max_files = ini_get('max_file_uploads');

        return [
            ['id', 'integer'],
            ['name', 'string'],
            ['files', 'file', 'maxFiles' => $max_files, 'maxSize' => $max_file_size],
        ];
    }




    public function create()
    {
        $list = [];
        foreach ($this->files as $file) {
            if (!empty($file)) {
                $filename = \Yii::getAlias('@runtime') . '/' . time() . $file->extension;
                $file->saveAs($filename);
                $size = filesize($filename);
                $content = file_get_contents($filename);

                $record = new File();
                $record->name           = $file->baseName;
                $record->binary         = chunk_split(base64_encode($content));
                $record->extension      = $file->extension;
                $record->size           = $size;
                $record->mime           = $file->type;
                $record->user_create_id = Yii::$app->user->identity->getId();
                $record->insert();

                $list[] = $record->id;
                unlink($filename);//удаляем временный файл

                //делаем запись в истории файлов
                FileHistory::AddHistory($record->id,FileHistory::CREATE);
            }
        }
        //возвращаем список id загруженых файлов
        return $list;
    }

    //обновление записей
    public function update()
    {
        $date = new \DateTime();
        $file = File::findFile($this->id);
        $file->name = $this->name;
        $file->updated_at = $date->getTimestamp();
        $file->save();
        return true;
    }
}
