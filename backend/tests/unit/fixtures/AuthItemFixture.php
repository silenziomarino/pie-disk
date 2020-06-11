<?php

namespace backend\tests\unit\fixtures;

use backend\modules\base\models\Entity\AuthItem;
use yii\test\ActiveFixture;

class AuthItemFixture extends ActiveFixture
{
    public $modelClass = AuthItem::class;
}