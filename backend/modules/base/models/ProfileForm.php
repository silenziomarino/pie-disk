<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\Profile;
use backend\modules\helpers\file\FileHelpers;
use Yii;
use yii\base\Model;

/**
 * модель обрабоки формы профиля пользователя
 * Class ProfileForm
 * @package backend\modules\base\models
 */
class ProfileForm extends Model
{
    public $first_name;
    public $last_name;
    public $middle_name;
    public $photo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $upload_max_filesize = ini_get('upload_max_filesize');
        $max_file_size = FileHelpers::ReturnBytes($upload_max_filesize);
        $max_files = ini_get('max_file_uploads');
        return [

            ['last_name',   'trim'],
            ['last_name',   'required', 'message' => 'Заполните поле фамилия'],
            ['last_name',   'match',    'pattern' => '/[а-яёa-z-]*/i'],
            ['last_name',   'string',    'length' => [3, 24]],

            ['first_name',  'trim'],
            ['first_name',  'required', 'message' => 'Заполните поле имя'],
            ['first_name',  'match',    'pattern' => '/[а-яёa-z-]*/i'],
            ['first_name',  'string',    'length' => [3, 24]],

            ['middle_name', 'trim'],
            ['middle_name', 'required', 'message' => 'Заполните поле отчество'],
            ['middle_name', 'match',    'pattern' => '/[а-яёa-z-]*/i'],
            ['middle_name', 'string',    'length' => [3, 24]],

            ['photo', 'file', 'maxFiles' => 1, 'maxSize' => $max_file_size],

        ];
    }

    public function update()
    {
        $id = Yii::$app->user->getId();
        $profile = Profile::GetProfile($id);
        $profile->last_name = $this->last_name;
        $profile->first_name = $this->first_name;
        $profile->middle_name = $this->middle_name;
        $profile->update();

        //сохраняем фотку
        foreach ($this->photo as $file) {
            if (!empty($file)) {
                $puth = \Yii::getAlias('@backend') . '/web';
                $name = '/img/avatars/' . uniqid() .'.'. $file->extension;
                $file_name = $puth.$name;
                $file->saveAs($file_name);
                $this->ImageResize($file_name,250,100);
                $profile->photo = $name;
                $profile->update();
            }
            break;
        }

    }

    /**
     * изменяет размер фото
     * @param $file_name  - абсолютное имя файла
     * @param $new_w      - ширина изображения
     * @param $quality    - качество
     */
    private function ImageResize($file_name, $new_w, $quality)
    {
        try {
            $old_photo = imagecreatefrompng($file_name);
        } catch (\Exception $e) {
            $old_photo = imagecreatefromjpeg($file_name);
        }
        $old_w = imagesx($old_photo);
        $old_h = imagesy($old_photo);
        $min_l = ($old_w > $old_h) ? $old_h : $old_w;
        $k = $new_w / $min_l;

        $w = intval($old_w * $k);
        $h = intval($old_h * $k);

        $new_p1 = imagecreatetruecolor($w, $h);
        imagecopyresampled($new_p1, $old_photo, 0, 0, 0, 0, $w, $h, $old_w, $old_h);

        $im2 = imagecrop($new_p1, ['x' => 0, 'y' => 0, 'width' => $new_w, 'height' => $new_w]);
        try {
            imagejpeg($im2, $file_name, $quality);//создаем новый
        } catch (\Exception $e) {
            imagepng($im2, $file_name, $quality);//создаем новый
        }
        imagedestroy($old_photo);
        imagedestroy($new_p1);
        imagedestroy($im2);
    }
}
