<?php

use yii\db\Migration;

class m161219_130859_contract_signed_fio extends Migration
{
	public $tableName = '{{%lease_contracts}}';

	public function up()
	{
		$this->addColumn($this->tableName, 'signed_fio', 'VARCHAR(250)');
	}

	public function down()
	{
		$this->dropColumn($this->tableName, 'signed_fio');
		return true;
	}
}
