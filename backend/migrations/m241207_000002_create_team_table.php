<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%team}}`.
 */
class m241207_000002_create_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('team', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'position' => $this->string()->notNull(),
            'bio' => $this->text(),
            'image_url' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('team');
    }
}
