<?php

use yii\db\Migration;

/**
 * Handles the creation of table `msg`.
 */
class m180424_194805_create_msg_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('msg', [
            'id' => $this->primaryKey(),
            'from' => $this->integer(11)->defaultValue(null),
            'to' => $this->integer(11)->defaultValue(null),
            'chat_id' => $this->integer(11)->defaultValue(null),
            'textMsg' => $this->text(),
            'dt_add' => $this->integer(11),
            'status' => $this->integer(1)->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('msg');
    }
}
