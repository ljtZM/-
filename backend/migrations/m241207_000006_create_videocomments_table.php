<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%videocomments}}`.
 */
class m241207_000006_create_videocomments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('videocomments', [
            'id' => $this->primaryKey(),
            'video_id' => $this->integer()->notNull(),
            'comment' => $this->text()->notNull(),
            'comment_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'username' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_videocomments_video_id',
            'videocomments',
            'video_id',
            'videos',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_videocomments_username',
            'videocomments',
            'username',
            'users',
            'username',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('videocomments');
    }
}
