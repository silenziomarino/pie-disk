<?php
use yii\db\Migration;

class m200101080808_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'         => $this->primaryKey(),
            'email'      => $this->string(64)->notNull()->unique()->comment('email'),
            'auth_key'   => $this->string(32)->notNull(),
            'password'   => $this->string()->notNull()->unique()->comment('пароль'),
            'created_at' => $this->integer()->notNull()->comment('дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('дата обновления'),
            'lock'       => $this->boolean()->comment('черный список'),
            'inviter_id' => $this->integer()->comment('id приглашающего'),
        ], $tableOptions);

        $this->addForeignKey(
            "user_id_inviter_id_fk",
            "user",
            "inviter_id",
            "user",
            "id",
            "SET NULL",
            "SET NULL"
        );

        $this->insert('user',[
            'id' => 1,
            'email' => 'admin',
            'auth_key' => 'OsPQgcmhlo5wAlsvDPSrow-Dh5H6L2qk',
            'password' => '$2y$13$F/6PI29KjnOxBA6L798zwubM.d7zoXM4ryjyGTFo7h.c6f85KMHcq',
            'created_at' => 1581250127,
            'updated_at' => 1581250127,
        ]);
        if ($this->db->driverName === 'pgsql') {
            $this->execute('ALTER SEQUENCE user_id_seq RESTART WITH 2;');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
