<?php

use yii\db\Migration;

class m211103_165725_create_table_tasks extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%tasks}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'title' => $this->string()->notNull(),
                'description' => $this->text()->notNull(),
                'city_id' => $this->integer()->unsigned(),
                'price' => $this->integer()->unsigned(),
                'category_id' => $this->integer()->unsigned()->notNull(),
                'client_id' => $this->integer()->unsigned()->notNull(),
                'performer_id' => $this->integer()->unsigned(),
                'deadline' => $this->dateTime(),
                'address' => $this->string(),
                'long' => $this->string(100),
                'lat' => $this->string(100),
                'status_id' => $this->integer()->unsigned()->notNull(),
                'created' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'tasks_FK',
            '{{%tasks}}',
            ['city_id'],
            '{{%cities}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'tasks_FK_1',
            '{{%tasks}}',
            ['category_id'],
            '{{%categories}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'tasks_FK_2',
            '{{%tasks}}',
            ['client_id'],
            '{{%users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'tasks_FK_3',
            '{{%tasks}}',
            ['performer_id'],
            '{{%users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'tasks_FK_4',
            '{{%tasks}}',
            ['status_id'],
            '{{%statuses}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropTable('{{%tasks}}');
    }
}
