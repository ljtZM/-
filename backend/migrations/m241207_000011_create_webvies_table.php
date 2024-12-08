<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%webvies}}`.
 */
class m241207_000011_create_webvies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('webviews', [
            'views' => $this->integer()->defaultValue(0)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('webviews');
    }
}
