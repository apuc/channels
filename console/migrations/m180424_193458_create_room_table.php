<?php

use yii\db\Migration;

/**
 * Handles the creation of table `room`.
 */
class m180424_193458_create_room_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('room', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'slug' => $this->string(255),
            'dt_add' => $this->integer(11),
            'status' => $this->integer(1)->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('room');
    }
}
