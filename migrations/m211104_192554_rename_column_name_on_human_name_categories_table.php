<?php

use yii\db\Migration;

/**
 * Class m211104_192554_rename_column_name_on_human_name_categories_table
 */
class m211104_192554_rename_column_name_on_human_name_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('categories', 'name', 'human_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211104_192554_rename_column_name_on_human_name_categories_table cannot be reverted.\n";

        return false;
    }

}
