<?php

namespace backend\modules\base\models\Entity;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * Class AuthItem
 * @package backend\modules\base\models\Entity
 */
class AuthItem extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_item}}';
    }
}

