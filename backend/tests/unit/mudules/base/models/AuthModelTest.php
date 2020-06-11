<?php

namespace backend\tests\mudules\base\models;

use backend\modules\base\models\AuthModel;
use backend\modules\base\models\LoginForm;
use backend\tests\unit\fixtures\AuthAssignmentFixture;
use backend\tests\unit\fixtures\ProfileFixture;
use backend\tests\unit\fixtures\UserFixture;

class AuthModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user'           => ['class' => UserFixture::class],
            'profile'        => ['class' => ProfileFixture::class],
            'AuthAssignment' => ['class' => AuthAssignmentFixture::class],
        ]);

        //аутентификация тестового пользователя
        \Yii::$app->user->enableSession = false;
        $LoginForm = new LoginForm;
        $LoginForm->email = 'admin';
        $LoginForm->password = '123456';
        $LoginForm->login();
    }

    public function testGetListUserWithBigRole()
    {
        $res = AuthModel::GetListUserWithBigRole();
        $this->assertNotEmpty($res,'список пользователей не должен быть пустым');
    }

}