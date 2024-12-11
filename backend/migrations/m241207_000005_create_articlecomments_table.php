<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%articlecomments}}`.
 */
class m241207_000005_create_articlecomments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('articlecomments', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'comment' => $this->text()->notNull(),
            'comment_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'username' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_articlecomments_article_id',
            'articlecomments',
            'article_id',
            'articles',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_articlecomments_username',
            'articlecomments',
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
        $this->dropTable('articlecomments');
    }
}
