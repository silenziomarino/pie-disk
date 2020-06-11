<?php

use yii\db\Expression;
use yii\db\Migration;

class M200229143310_type_files extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('dic_type_file', [
            'id'             => $this->primaryKey()->defaultValue('SERIAL')->notNull()->comment('id записи'),
            'name'           => $this->string(100)->notNull()->comment('название'),
        ]);
        $this->addCommentOnTable('dic_type_file', 'справочник форматов загружаемых файлов');

        $this->insert('dic_type_file',['name' => 'doc']);
        $this->insert('dic_type_file',['name' => 'docx']);
        $this->insert('dic_type_file',['name' => 'xls']);
        $this->insert('dic_type_file',['name' => 'xlsx']);
        $this->insert('dic_type_file',['name' => 'ppt']);
        $this->insert('dic_type_file',['name' => 'pptx']);
        $this->insert('dic_type_file',['name' => 'rtf']);
        $this->insert('dic_type_file',['name' => 'pdf']);
        $this->insert('dic_type_file',['name' => 'png']);
        $this->insert('dic_type_file',['name' => 'jpg']);
        $this->insert('dic_type_file',['name' => 'gif']);
        $this->insert('dic_type_file',['name' => 'psd']);
        $this->insert('dic_type_file',['name' => 'djvu']);
        $this->insert('dic_type_file',['name' => 'fb2']);
        $this->insert('dic_type_file',['name' => 'ps']);

        if ($this->db->driverName === 'pgsql') {
            $this->execute('ALTER SEQUENCE dic_type_file_id_seq RESTART WITH 16;');
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('dic_type_file');
    }
}
