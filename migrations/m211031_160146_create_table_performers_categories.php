<?php

use yii\db\Migration;

class m211031_160146_create_table_performers_categories extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%performers_categories}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'performer_id' => $this->integer()->unsigned()->notNull(),
                'category_id' => $this->integer()->unsigned()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('users_categories_UN', '{{%performers_categories}}', ['performer_id', 'category_id'], true);

        $this->addForeignKey(
            'users_categories_FK',
            '{{%performers_categories}}',
            ['performer_id'],
            '{{%users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'users_categories_FK_1',
            '{{%performers_categories}}',
            ['category_id'],
            '{{%categories}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%performers_categories}}');
    }
}
