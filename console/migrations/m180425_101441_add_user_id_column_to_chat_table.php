<?php

use yii\db\Migration;

/**
 * Handles adding user_id to table `chat`.
 */
class m180425_101441_add_user_id_column_to_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('chat', 'user_id', $this->integer(11)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('chat', 'user_id');
    }
}
