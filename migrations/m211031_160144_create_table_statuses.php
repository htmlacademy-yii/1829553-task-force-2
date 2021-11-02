<?php

use yii\db\Migration;

class m211031_160144_create_table_statuses extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%statuses}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'system_name' => $this->string(100)->notNull(),
                'human_name' => $this->string(100)->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('statuses_UN', '{{%statuses}}', ['system_name'], true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%statuses}}');
    }
}
