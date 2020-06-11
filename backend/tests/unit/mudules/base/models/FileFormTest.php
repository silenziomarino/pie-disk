<?php

namespace backend\tests\mudules\base\models;

use backend\modules\base\models\FileForm;
use backend\modules\base\models\LoginForm;
use yii\web\UploadedFile;


class FileFormTest extends \Codeception\Test\Unit
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

    //todo a.curkan
//    public function testFileCreate()
//    {
//        $file = new UploadedFile();
//        $file->name = 'файлик';
//        $file->type = 'image/png';
//        $file->tempName = __DIR__.'/files/favicon.png';
//
//        $model = new FileForm(['scenario' => FileForm::FILE_CREATE]);
//        $model->files[] = $file;
//        $model->create();
//    }
//
//    public function testFileUpdate()
//    {
//        $model = new FileForm(['scenario' => FileForm::FILE_UPDATE]);
//    }

}