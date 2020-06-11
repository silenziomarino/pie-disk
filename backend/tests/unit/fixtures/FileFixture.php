<?php

namespace backend\tests\unit\fixtures;

use backend\modules\base\models\Entity\File;
use yii\test\ActiveFixture;

class FileFixture extends ActiveFixture
{
    public $modelClass = File::class;
}