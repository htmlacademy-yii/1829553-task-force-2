<?php

use yii\db\Migration;

class m211103_165721_create_table_cities extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%cities}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string()->notNull(),
                'lat' => $this->string(100),
                'long' => $this->string(100),
            ],
            $tableOptions
        );

        $this->createIndex('cities_UN', '{{%cities}}', ['name', 'lat', 'long'], true);
    }

    public function down()
    {
        $this->dropTable('{{%cities}}');
    }
}
