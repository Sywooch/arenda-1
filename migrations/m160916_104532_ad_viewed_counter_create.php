<?php

use yii\db\Migration;
use yii\db\Schema;

class m160916_104532_ad_viewed_counter_create extends Migration
{
    public $tableName = '{{%ad_viewed_counter}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'ad_id' => Schema::TYPE_INTEGER,
            'date_created' => Schema::TYPE_INTEGER,
            'views' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('ad_viewed_counter_ads_fk', $this->tableName, 'ad_id', '{{%ads}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('ad_viewed_counter_ads_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}