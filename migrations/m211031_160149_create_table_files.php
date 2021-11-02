<?php

use yii\db\Migration;

class m211031_160149_create_table_files extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%files}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string()->notNull(),
                'path' => $this->string()->notNull(),
                'client_id' => $this->integer()->unsigned()->notNull(),
                'task_id' => $this->integer()->unsigned()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('files_UN', '{{%files}}', ['name', 'path'], true);

        $this->addForeignKey(
            'files_FK',
            '{{%files}}',
            ['client_id'],
            '{{%users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'files_FK_1',
            '{{%files}}',
            ['task_id'],
            '{{%tasks}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%files}}');
    }
}
