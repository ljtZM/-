      
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
        // 将 views 设置为主键
        $this->addPrimaryKey('pk_views', 'webviews', 'views');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('webviews');
    }
}

    