<?php
use yii\db\Migration;

/**
 * добавление ролей по умолчанию
 * Class M200101080809_init_role
 */
class M200101080809_init_role extends Migration
{
    public function safeUp()
    {
        $this->insert('auth_item',[
            'name' => 'visitor',
            'type' => 1,
            'description' => 'Пользователь',
            'created_at' => 1581251484,
            'updated_at' => 1581251484,
        ]);
        $this->insert('auth_item',[
            'name' => 'moderator',
            'type' => 1,
            'description' => 'Модератор',
            'created_at' => 1581251484,
            'updated_at' => 1581251484,
        ]);
        $this->insert('auth_item',[
            'name' => 'admin',
            'type' => 1,
            'description' => 'администратор',
            'created_at' => 1581251484,
            'updated_at' => 1581251484,
        ]);
        //--------------добавляем наследование ролей--------------------------
        $this->insert('auth_item_child',[
            'parent' => 'admin',
            'child' => 'moderator',
        ]);
        $this->insert('auth_item_child',[
            'parent' => 'moderator',
            'child' => 'visitor',
        ]);
        //--------------добаляем  роль admin адимистратору--------------------
        $this->insert('auth_assignment',[
            'item_name' => 'admin',
            'user_id' => 1,
            'created_at' => 1581251484,
        ]);
    }

    public function safeDown()
    {
        $this->truncateTable('auth_assignment');
        $this->truncateTable('auth_item_child');
        $this->truncateTable('auth_item');
    }
}
