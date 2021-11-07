<?php

use yii\db\Migration;

class m211103_165728_create_table_reviews extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%reviews}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'client_id' => $this->integer()->unsigned()->notNull(),
                'performer_id' => $this->integer()->unsigned()->notNull(),
                'task_id' => $this->integer()->unsigned()->notNull(),
                'description' => $this->string()->notNull(),
                'grade' => $this->tinyInteger()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('reviews_UN', '{{%reviews}}', ['task_id'], true);

        $this->addForeignKey(
            'reviews_FK',
            '{{%reviews}}',
            ['client_id'],
            '{{%users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'reviews_FK_1',
            '{{%reviews}}',
            ['performer_id'],
            '{{%users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'reviews_FK_2',
            '{{%reviews}}',
            ['task_id'],
            '{{%tasks}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropTable('{{%reviews}}');
    }
}
