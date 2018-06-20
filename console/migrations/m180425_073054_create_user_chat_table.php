<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_chat`.
 */
class m180425_073054_create_user_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_chat', [
            'user_id' => $this->integer(11)->notNull(),
            'chat_id' => $this->integer(11)->notNull(),
        ]);

        $this->addPrimaryKey(null, 'user_chat', ['user_id', 'chat_id']);
        $this->createIndex('chat_id', 'user_chat', 'chat_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_chat');
    }
}
