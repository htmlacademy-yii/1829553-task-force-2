<?php

use yii\db\Migration;

class m211031_160145_create_table_users extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%users}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'email' => $this->string()->notNull(),
                'name' => $this->string()->notNull(),
                'password' => $this->string(64)->notNull(),
                'birthday' => $this->dateTime()->notNull(),
                'is_client' => $this->boolean()->notNull(),
                'about' => $this->text()->notNull(),
                'phone' => $this->string(11)->notNull(),
                'telegram' => $this->string(64)->notNull(),
                'avatar' => $this->string(),
                'hide_contacts' => $this->boolean()->notNull(),
                'city_id' => $this->integer()->unsigned()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('users_UN', '{{%users}}', ['email'], true);

        $this->addForeignKey(
            'users_FK',
            '{{%users}}',
            ['city_id'],
            '{{%cities}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
