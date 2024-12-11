<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%acticle_likes}}`.
 */
class m241207_000007_create_acticle_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_likes', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'likes' => $this->integer()->defaultValue(0), // 点赞数
        ]);

        // 设置外键约束
        $this->addForeignKey(
            'fk_article_likes_article_id', // 外键名称
            'article_likes', // 表名
            'article_id', // 本表字段
            'articles', // 关联的表
            'id', // 关联表的字段
            'CASCADE' // 删除时级联
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // 删除外键约束和表
        $this->dropForeignKey('fk_article_likes_article_id', 'article_likes');
        $this->dropTable('article_likes');
    }
}
