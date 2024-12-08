<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%scraped_content}}`.
 */
class m241207_000009_create_scraped_content_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('scraped_content', [
            'id' => $this->primaryKey(),
            'source_url' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text(),
            'type' => "ENUM('article', 'video') NOT NULL",
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('scraped_content');
    }
}
