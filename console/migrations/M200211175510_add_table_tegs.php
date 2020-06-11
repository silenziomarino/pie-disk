<?php

use yii\db\Expression;
use yii\db\Migration;

class M200211175510_add_table_tegs extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('dic_teg', [
            'id'   => $this->primaryKey()->defaultValue('SERIAL')->notNull()->comment('id записи'),
            'name' => $this->string(100)->notNull()->comment('название тэга'),
        ]);
        $this->addCommentOnTable('dic_teg', 'таблица тэгов');
        //-------------------------------------------------------------
        $this->createTable('file_to_teg', [
            'id'      => $this->primaryKey()->defaultValue('SERIAL')->notNull()->comment('id записи'),
            'file_id' => $this->integer()->comment('название тэга'),
            'teg_id'  => $this->integer()->comment('название тэга'),
        ]);
        $this->addCommentOnTable('file_to_teg', 'таблица сопоставления тэгов и файлов');
        //-------------------------------------------------------------
        $this->addForeignKey(
            "file_to_teg_file_id_fk",
            "file_to_teg",
            "file_id",
            "file",
            "id",
            "CASCADE",
            "CASCADE"
        );
        $this->addForeignKey(
            "file_to_teg_teg_id_fk",
            "file_to_teg",
            "teg_id",
            "dic_teg",
            "id",
            "CASCADE",
            "CASCADE"
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('file_to_teg');
        $this->dropTable('dic_teg');
    }
}
