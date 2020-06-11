<?php

namespace backend\tests\mudules\base\models;

use backend\modules\base\models\LoginForm;
use backend\modules\base\models\UserModel;
use backend\tests\unit\fixtures\AuthAssignmentFixture;
use backend\tests\unit\fixtures\ProfileFixture;
use backend\tests\unit\fixtures\UserFixture;

class UserModelTest extends \Codeception\Test\Unit
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

    public function testDeleteUser()
    {
        $res = UserModel::deleteUser('2');
        $this->assertTrue($res,'Ошибка при удалении пользователя');
    }

    public function testLockUser()
    {
        $res = UserModel::lockUser('2', true);
        $this->assertTrue($res,'Ошибка при добавления пользователя в черны список');
    }
}