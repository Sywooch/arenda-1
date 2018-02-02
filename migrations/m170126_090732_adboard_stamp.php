<?php

use yii\db\Migration;

class m170126_090732_adboard_stamp extends Migration
{
	public $tableName = '{{%ad_board}}';
	
    public function up()
    {
		$this->addColumn($this->tableName, 'feed_updated', 'INTEGER DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'feed_updated');
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
