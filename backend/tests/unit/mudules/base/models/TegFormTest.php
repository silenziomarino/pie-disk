<?php

namespace backend\tests\mudules\base\models;

use backend\modules\base\models\TegForm;
use backend\tests\unit\fixtures\FileFixture;

class TegFormTest extends \Codeception\Test\Unit
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

    public function testUpdateFileTeg()
    {
        $model = new TegForm();
        $model->id = '3';
        $model->str = 'php, info, report';
        $this->assertTrue($model->validate(),'Запись не валидна');

        $this->assertTrue($model->update(),'ошибка привязки новых хэштеов к файлу');
        //findTegByName($name)
    }
}