<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth}}`.
 */
class m220110_134154_create_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer() . ' UNSIGNED NOT NULL',
            'vk_user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth}}');
    }
}
