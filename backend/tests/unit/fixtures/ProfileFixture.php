<?php

namespace backend\tests\unit\fixtures;

use backend\modules\base\models\Entity\Profile;
use yii\test\ActiveFixture;

class ProfileFixture extends ActiveFixture
{
    public $modelClass = Profile::class;
}