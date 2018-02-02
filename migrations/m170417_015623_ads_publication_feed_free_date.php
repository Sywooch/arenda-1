<?php

use yii\db\Migration;

class m170417_015623_ads_publication_feed_free_date extends Migration
{
    public $tableName = '{{%ads_publications}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'feed_free_date', 'INTEGER NULL');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'feed_free_date');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
