<?php

use yii\db\Migration;

/**
 * Handles adding type to table `chat`.
 */
class m180616_113622_add_type_column_to_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('chat', 'type', $this->integer(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('chat', 'type');
    }
}
