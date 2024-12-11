<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%video_likes}}`.
 */
class m241207_000008_create_video_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('video_likes', [
            'id' => $this->primaryKey(),
            'video_id' => $this->integer()->notNull(),
            'likes' => $this->integer()->defaultValue(0), // 点赞数
        ]);

        // 设置外键约束
        $this->addForeignKey(
            'fk_video_likes_video_id', // 外键名称
            'video_likes', // 表名
            'video_id', // 本表字段
            'videos', // 关联的表
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
        $this->dropForeignKey('fk_video_likes_video_id', 'video_likes');
        $this->dropTable('video_likes');
    }
}
