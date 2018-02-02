<?php

use yii\db\Migration;

class m170127_095741_ad_boards extends Migration
{
	public $tableName = '{{%ads_publications}}';
	
    public function up()
    {
		$this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id'),
            'ad_id' => $this->integer()->comment('Ad'),
            'board_id' => $this->integer()->comment('Board'),
            'price_code' => $this->string()->comment('Price conditions code'),
        ]);
        $this->dropColumn('{{%ads}}', 'place_add_to');
    }

    public function down()
    {
		$this->dropTable($this->tableName);
		$this->addColumn('{{%ads}}', 'place_add_to', 'JSON');
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
