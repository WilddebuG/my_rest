<?php

use yii\db\Migration;

class m180713_130322_add_city_id_column_to_user_profile extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user_profile}}', 'city_id', $this->integer()->notNull()->defaultValue(1));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user_profile}}', 'city_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180704_074951_add_city_id_column_to_userProfile cannot be reverted.\n";

        return false;
    }
    */
}
