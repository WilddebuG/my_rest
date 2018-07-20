<?php

use yii\db\Migration;

class m180713_130318_create_table_city extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'city' => $this->string()->notNull(),
            'latitude' => $this->double()->notNull(),
            'longitude' => $this->double()->notNull(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }
}
