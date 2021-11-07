<?php

use yii\db\Migration;

/**
 * Class m211104_194016_rename_column_icon_on_system_name_categories_table
 */
class m211104_194016_rename_column_icon_on_system_name_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('categories', 'icon', 'system_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211104_194016_rename_column_icon_on_system_name_categories_table cannot be reverted.\n";

        return false;
    }

}
