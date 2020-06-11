<?php

namespace backend\tests\mudules\base\models;

use backend\modules\base\models\Entity\TypeFile;
use backend\modules\base\models\FileTypeForm;

class FileTypeFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    public function testUpdateFileType()
    {
        $model = new FileTypeForm();
        $model->str = 'avi,mp4,mp3';

        $this->assertTrue($model->validate(),'Запись не валидна');
        $model->update();
        $res = TypeFile::findTypeByName('mp3');
        $this->assertNotEmpty($res,'Должен был вернуть запись с именем "MP3"');
    }
}