<?php

use yii\db\Migration;

class m161216_103739_lease_contracts_new_fields extends Migration
{
	public $tableName = '{{%lease_contracts}}';

	public function up()
	{
		$this->renameColumn($this->tableName, 'date_end', 'lease_term');
		$this->addColumn($this->tableName, 'deposit_needed', 'SMALLINT DEFAULT 0');
		$this->addColumn($this->tableName, 'deposit_sum', 'INTEGER DEFAULT 0');
		$this->addColumn($this->tableName, 'deposit_date_payed', 'INTEGER DEFAULT 0');
		$this->addColumn($this->tableName, 'bills_payed_by', 'SMALLINT DEFAULT 1');
		$this->addColumn($this->tableName, 'bills_payed_percent', 'SMALLINT DEFAULT 1');
	}

	public function down()
	{
		$this->renameColumn($this->tableName, 'lease_term', 'date_end');
		$this->dropColumn($this->tableName, 'deposit_needed');
		$this->dropColumn($this->tableName, 'deposit_sum');
		$this->dropColumn($this->tableName, 'deposit_date_payed');
		$this->dropColumn($this->tableName, 'bills_payed_by');
		$this->dropColumn($this->tableName, 'bills_payed_percent');

		return true;
	}
}
