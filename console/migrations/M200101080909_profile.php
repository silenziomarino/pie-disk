<?php

use yii\db\Migration;

class M200101080909_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        //-------------------------------------------------------------------------------------------
        $this->createTable('profile', [
            'id'          => $this->primaryKey()->defaultValue('SERIAL')->notNull()->comment('id записи'),
            'user_id'     => $this->integer()->notNull()->comment('id пользователя'),
            'first_name'  => $this->string(50)->notNull()->comment('Имя'),
            'last_name'   => $this->string(50)->notNull()->comment('Фамилия'),
            'middle_name' => $this->string(50)->notNull()->comment('Отчество'),
            'photo'       => $this->text()->comment('фото'),
            'phone'       => $this->string(15)->comment('телефон'),
            'auth_item_name' => $this->string()->comment('имя роли (для подтверждеия прав)'),
        ]);
        $this->addCommentOnTable('profile', 'Профиль пользователя');

        $this->addForeignKey(
            "profile_user_id_fk",
            "profile",
            "user_id",
            "user",
            "id",
            "CASCADE",
            "CASCADE"
        );
        $this->addForeignKey(
            "profile_auth_item_name_fk",
            "profile",
            "auth_item_name",
            "auth_item",
            "name",
            "SET NULL",
            "CASCADE"
        );
        $this->insert('profile',[
            'user_id'     => 1,
            'first_name'  => 'Администратор',
            'last_name'   => '',
            'middle_name' => '',
        ]);
        //---------------------------------------------------------------------------------------------
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('profile');
    }

}
