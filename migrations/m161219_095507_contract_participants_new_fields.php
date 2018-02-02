<?php

use yii\db\Migration;

class m161219_095507_contract_participants_new_fields extends Migration
{
	public $tableName = '{{%lease_contract_participants}}';

	public function up()
	{
		$this->addColumn($this->tableName, 'signed', 'SMALLINT DEFAULT 0');
		$this->addColumn($this->tableName, 'signed_fio', 'VARCHAR(250)');
	}

	public function down()
	{
		$this->dropColumn($this->tableName, 'signed');
		$this->dropColumn($this->tableName, 'signed_fio');
		return true;
	}
}
