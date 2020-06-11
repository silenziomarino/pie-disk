<?php

namespace backend\tests\unit\fixtures;

use backend\modules\base\models\Entity\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}