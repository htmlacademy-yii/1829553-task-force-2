<?php

use yii\db\Migration;

class m211031_160142_create_table_categories extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%categories}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string(100)->notNull(),
                'icon' => $this->string(64)->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('categories_UN', '{{%categories}}', ['name'], true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
