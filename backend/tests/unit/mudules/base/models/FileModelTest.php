<?php

namespace backend\tests\mudules\base\models;

use backend\modules\base\models\Entity\File;
use backend\modules\base\models\FileModel;
use backend\tests\unit\fixtures\FileFixture;

class FileModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'file' => ['class' => FileFixture::class],
        ]);
    }

    /**
     * Тестирует удаление файла из корзины
     */
    public function testDropTrashFile()
    {
        $file_id = 2;
        FileModel::DropTrashFile();
        $res = File::findFile($file_id);
        $this->assertEmpty($res,'файл с id=2 должен был быть удален!');
    }
}