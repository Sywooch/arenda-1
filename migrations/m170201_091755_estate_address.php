<?php

use yii\db\Migration;

class m170201_091755_estate_address extends Migration
{
	public $tableName = '{{%real_estate}}';
	
    public function up()
    {
		$this->addColumn($this->tableName, 'region_id', 'CHARACTER VARYING(50)');
		$this->addColumn($this->tableName, 'region', 'CHARACTER VARYING(100)');
		$this->addColumn($this->tableName, 'district_id', 'CHARACTER VARYING(50)');
		$this->addColumn($this->tableName, 'district', 'CHARACTER VARYING(100)');
		$this->addColumn($this->tableName, 'city_id', 'CHARACTER VARYING(50)');
		$this->addColumn($this->tableName, 'metro', 'CHARACTER VARYING(100)');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'region_id');
		$this->dropColumn($this->tableName, 'region');
		$this->dropColumn($this->tableName, 'district_id');
		$this->dropColumn($this->tableName, 'district');
		$this->dropColumn($this->tableName, 'city_id');
		$this->dropColumn($this->tableName, 'metro');
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
