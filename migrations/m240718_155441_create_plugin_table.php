<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plugin}}`.
 */
class m240718_155441_create_plugin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plugin}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('inactive'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%plugin}}');
    }
}
