<?php

use yii\db\Migration;

class M200314123310_notify extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('notify', [
            'id'      => $this->primaryKey()->defaultValue('SERIAL')->notNull()->comment('id записи'),
            'params'  => $this->json()->notNull()->comment('праметры'),
            'view'    => $this->string(255)->notNull()->comment('название вида'),
            'user_id' => $this->integer()->notNull()->comment('кому уведомление'),

        ]);
        $this->addCommentOnTable('file', 'таблица уведомлений');

        $this->addForeignKey(
            "notify_user_id_fk",
            "notify",
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
        $this->dropTable('notify');
    }
}
