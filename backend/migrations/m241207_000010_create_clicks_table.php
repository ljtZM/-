<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clicks}}`.
 */
class m241207_000010_create_clicks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('clicks', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer()->notNull(),
            'content_type' => "ENUM('article', 'video') NOT NULL",
            'click_count' => $this->integer()->defaultValue(0),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('clicks');
    }
}
