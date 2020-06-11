<?php

namespace backend\tests\unit\fixtures;

use backend\modules\base\models\Entity\FileHistory;
use yii\test\ActiveFixture;

class FileHistoryFixture extends ActiveFixture
{
    public $modelClass = FileHistory::class;
}