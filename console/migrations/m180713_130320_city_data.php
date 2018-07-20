<?php

use yii\db\Migration;

class m180713_130320_city_data extends Migration
{
    public function safeUp()
    {
        $this->insert('{{city}}', ['latitude' => '49.839683', 'longitude' => '24.029717', 'city' => 'Львів' ]);
        $this->insert('{{city}}', ['latitude' => '49.233082', 'longitude' => '28.4682169', 'city' => 'Вінниця' ]);
        $this->insert('{{city}}', ['latitude' => '48.464717', 'longitude' => '35.046183', 'city' => 'Дніпропетровськ' ]);
        $this->insert('{{city}}', ['latitude' => '48.922633', 'longitude' => '24.711117', 'city' => 'Івано-Франківськ' ]);
        $this->insert('{{city}}', ['latitude' => '50.449879', 'longitude' => '30.523803', 'city' => 'Київ' ]);
        $this->insert('{{city}}', ['latitude' => '50.747233', 'longitude' => '25.325383', 'city' => 'Луцьк' ]);
        $this->insert('{{city}}', ['latitude' => '46.975033', 'longitude' => '31.99458', 'city' => 'Миколаїв' ]);
        $this->insert('{{city}}', ['latitude' => '46.482526', 'longitude' => '30.7233095', 'city' => 'Одеса' ]);
        $this->insert('{{city}}', ['latitude' => '49.588267', 'longitude' => '34.551417', 'city' => 'Полтава' ]);
        $this->insert('{{city}}', ['latitude' => '50.62', 'longitude' => '26.251617', 'city' => 'Рівне' ]);
        $this->insert('{{city}}', ['latitude' => '50.9077', 'longitude' => '34.7980', 'city' => 'Суми' ]);
        $this->insert('{{city}}', ['latitude' => '48.6208', 'longitude' => '22.287883', 'city' => 'Ужгород' ]);
        $this->insert('{{city}}', ['latitude' => '49.9935', 'longitude' => '36.230383', 'city' => 'Харків' ]);
        $this->insert('{{city}}', ['latitude' => '46.635417', 'longitude' => '32.616867', 'city' => 'Херсон' ]);
        $this->insert('{{city}}', ['latitude' => '49.422983', 'longitude' => '26.9871', 'city' => 'Хмельницький' ]);
        $this->insert('{{city}}', ['latitude' => '49.444433', 'longitude' => '32.059767', 'city' => 'Черкаси' ]);
        $this->insert('{{city}}', ['latitude' => '51.4982', 'longitude' => '31.28935', 'city' => 'Чернігів' ]);
        $this->insert('{{city}}', ['latitude' => '48.2920787', 'longitude' => '25.93583', 'city' => 'Чернівці' ]);

    }

    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180706_144220_city_data cannot be reverted.\n";

        return false;
    }
    */
}
