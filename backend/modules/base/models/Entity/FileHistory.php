<?php

namespace backend\modules\base\models\Entity;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * Class File
 * @package backend\modules\base\models\Entity
 * @property integer $id
 * @property integer $operation_id
 * @property integer $file_id
 * @property integer $user_id
 * @property string $date
 */
class FileHistory extends ActiveRecord
{
    const CREATE = 1;
    const TO_TRASH = 2;
    const RESTORE_FROM_TRASH = 3;
    const DOWNLOAD = 4;

    public static function tableName()
    {
        return '{{%file_history}}';
    }

    /**
     * добавление истории
     * @param $file_id
     * @param $status
     * @throws \Throwable
     */
    public static function AddHistory($file_id,$status)
    {
        $history = new FileHistory();
        $history->operation_id = (int)$status;
        $history->file_id = (int)$file_id;
        $history->user_id = Yii::$app->user->getId();
        $history->insert();
    }
}

