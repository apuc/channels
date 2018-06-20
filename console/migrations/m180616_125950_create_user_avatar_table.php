<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_avatar`.
 */
class m180616_125950_create_user_avatar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_avatar', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'avatar' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_avatar');
    }
}
