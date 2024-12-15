<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%website}}`.
 */
class m241215_095746_create_website_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('website', [
            'id' => $this->primaryKey(),
            'description' => $this->text(), // 网站描述
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('website');
    }
}
