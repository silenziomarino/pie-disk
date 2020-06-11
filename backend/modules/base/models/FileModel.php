<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\File;
use Yii;
use yii\base\Model;

/**
 * Class FileModel
 * @package backend\modules\base\models
 */
class FileModel extends Model
{
    //удаление файлов из корзины через 30 дней
    public static function DropTrashFile()
    {
        $date = new \DateTime();
        $date->modify('-30 day');
        Yii::$app->db->createCommand()->delete(File::tableName(), 'trash = TRUE AND updated_at <= :timestamp', [':timestamp' => $date->getTimestamp()])->execute();
    }
}
