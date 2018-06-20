<?php

use yii\db\Migration;

/**
 * Handles adding private to table `chat`.
 */
class m180430_110004_add_private_column_to_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('chat', 'private', $this->integer(1)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('chat', 'private');
    }
}
