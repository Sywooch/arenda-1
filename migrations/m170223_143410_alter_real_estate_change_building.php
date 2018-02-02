<?php

use yii\db\Migration;

class m170223_143410_alter_real_estate_change_building extends Migration
{
    public function up()
    {
        $this->alterColumn('ar_real_estate', 'building', 'VARCHAR(3)');
    }

    public function down()
    {
        $this->alterColumn('ar_real_estate', 'building', 'integer');
    }
}
