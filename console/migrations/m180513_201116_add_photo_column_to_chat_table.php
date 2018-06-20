<?php

use yii\db\Migration;

/**
 * Handles adding photo to table `chat`.
 */
class m180513_201116_add_photo_column_to_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('chat', 'photo', $this->string(255)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('chat', 'photo');
    }
}
