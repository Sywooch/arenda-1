<?php

use yii\db\Migration;

class m170208_082444_adboards_validation extends Migration
{
	public $tableName = '{{%ad_board}}';
	
    public function up()
    {
		$this->addColumn($this->tableName, 'validation', 'JSON');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'validation');
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
