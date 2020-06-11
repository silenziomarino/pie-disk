<?php

use yii\db\Expression;
use yii\db\Migration;

class M200101081010_files extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('file', [
            'id'             => $this->primaryKey()->defaultValue('SERIAL')->notNull()->comment('id записи'),
            'name'           => $this->string(100)->notNull()->comment('название файла'),
            'binary'         => $this->binary()->notNull()->comment('Содержимое файла'),
            'extension'      => $this->string(255)->notNull()->comment('Расширение файла'),
            'size'           => $this->integer()->notNull()->comment('Размер файла'),
            'mime'           => $this->string(255)->notNull()->comment('Mime файла'),
            'user_create_id' => $this->integer()->notNull()->comment('кто загрузил'),
            'date'           => $this->dateTime()->defaultValue(new Expression('now()'))->comment('дата и время загрузки файла'),
            'updated_at'     => $this->integer()->comment('дата обновления'),
            'trash'          => $this->boolean()->defaultValue(false)->comment('Корзина'),
        ]);
        $this->addCommentOnTable('file', 'таблица документов');

        $this->addForeignKey(
            "file_user_create_id_fk",
            "file",
            "user_create_id",
            "user",
            "id",
            "CASCADE",
            "CASCADE"
        );
        //------------------------------

        $this->createTable('dic_file_operation', [
            'id'             => $this->primaryKey()->defaultValue('SERIAL')->notNull()->comment('id записи'),
            'name' => $this->string(100)->notNull()->comment('название'),
        ]);
        $this->addCommentOnTable('dic_file_operation', 'справочник операций над файлами');

        $this->insert('dic_file_operation',['name' => 'Загрука на сайт']);
        $this->insert('dic_file_operation',['name' => 'Добавление в корзину']);
        $this->insert('dic_file_operation',['name' => 'Востановление']);
        $this->insert('dic_file_operation',['name' => 'Скачивание']);
        if ($this->db->driverName === 'pgsql') {
            $this->execute('ALTER SEQUENCE dic_file_operation_id_seq RESTART WITH 4;');
        }
        //------------------------------

        $this->createTable('file_history', [
            'id'             => $this->primaryKey()->defaultValue('SERIAL')->notNull()->comment('id записи'),
            'operation_id'   => $this->integer()->comment('id операции'),
            'file_id'        => $this->integer()->comment('id файла'),
            'user_id'        => $this->integer()->comment('id пользователя'),
            'date'           => $this->dateTime()->defaultValue(new Expression('now()'))->comment('дата совершения операции'),
        ]);
        $this->addCommentOnTable('file_history', 'история документов');

        $this->addForeignKey(
            "file_history_operation_id_fk",
            "file_history",
            "operation_id",
            "dic_file_operation",
            "id",
            "SET NULL",
            "CASCADE"
        );

        $this->addForeignKey(
            "file_history_file_id_fk",
            "file_history",
            "file_id",
            "file",
            "id",
            "CASCADE",
            "CASCADE"
        );
        $this->addForeignKey(
            "file_history_user_id_fk",
            "file_history",
            "user_id",
            "user",
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
        $this->dropTable('file_history');
        $this->dropTable('dic_file_operation');
        $this->dropTable('file');
    }
}
