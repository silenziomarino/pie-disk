<?php

namespace backend\tests\mudules\base\models;

use backend\modules\base\models\AuthItemModel;
use backend\modules\base\models\LoginForm;


class AuthItemModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        //аутентификация тестового пользователя
        \Yii::$app->user->enableSession = false;
        $LoginForm = new LoginForm;
        $LoginForm->email = 'admin';
        $LoginForm->password = '123456';
        $LoginForm->login();
    }

    public function testGetChild()
    {
        $items = AuthItemModel::GetChild();
        $this->assertNotEmpty($items, 'Список дочерних  ролей не должен быть пустым');
        return $items;
    }

    /**
     * @depends testGetChild
     * @param array $items  - список ролей
     */
    public function testIsRole($items)
    {
        $isRole = AuthItemModel::isRole($items[0]);
        $this->assertTrue($isRole, 'запись не является ролью');
    }

    public function testGetDicAuthItem(){
        $res2 = AuthItemModel::GetDicAuthItem();
        $this->assertNotEmpty($res2,'Справочник ролей не должен быть пустым');

    }
}