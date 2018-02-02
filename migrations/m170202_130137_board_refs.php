<?php

use yii\db\Migration;

class m170202_130137_board_refs extends Migration
{
	public $tableName1 = '{{%cian_areas}}';
	public $tableName2 = '{{%cian_metro}}';
	public $tableName3 = '{{%avito_cities}}';
	public $tableName4 = '{{%avito_districts}}';
	
    public function up()
    {
		$this->createTable($this->tableName1, [
            'id' => $this->primaryKey()->comment('id'),
            'cian_id' => $this->integer()->comment('CIAN ID'),
            'name' => $this->string()->comment('Name'),
        ]);
        $this->createTable($this->tableName2, [
            'id' => $this->primaryKey()->comment('id'),
            'cian_id' => $this->integer()->comment('CIAN ID'),
            'region_id' => $this->integer()->comment('Region ID'),
            'name' => $this->string()->comment('Name'),
        ]);
        $this->createTable($this->tableName3, [
            'id' => $this->primaryKey()->comment('id'),
            'avito_id' => $this->integer()->comment('Avito ID'),
            'name' => $this->string()->comment('Name'),
        ]);
        $this->createTable($this->tableName4, [
            'id' => $this->primaryKey()->comment('id'),
            'avito_id' => $this->integer()->comment('Avito ID'),
            'city_id' => $this->integer()->comment('City ID'),
            'name' => $this->string()->comment('Name'),
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName1);
        $this->dropTable($this->tableName2);
        $this->dropTable($this->tableName3);
        $this->dropTable($this->tableName4);
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
