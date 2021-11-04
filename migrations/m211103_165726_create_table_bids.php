<?php

use yii\db\Migration;

class m211103_165726_create_table_bids extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%bids}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'description' => $this->text()->notNull(),
                'price' => $this->integer()->unsigned()->notNull(),
                'task_id' => $this->integer()->unsigned()->notNull(),
                'is_refused' => $this->boolean()->notNull(),
                'performer_id' => $this->integer()->unsigned()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('bids_UN', '{{%bids}}', ['task_id', 'performer_id'], true);

        $this->addForeignKey(
            'bids_FK',
            '{{%bids}}',
            ['task_id'],
            '{{%tasks}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'bids_FK_1',
            '{{%bids}}',
            ['performer_id'],
            '{{%users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropTable('{{%bids}}');
    }
}
