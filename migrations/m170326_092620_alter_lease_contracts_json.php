<?php

use yii\db\Migration;

class m170326_092620_alter_lease_contracts_json extends Migration
{
	public $tableName = '{{%lease_contracts}}';

	public function up()
	{
		$this->addColumn($this->tableName, 'json', 'json');
	}

	public function down()
	{
		$this->dropColumn($this->tableName, 'json');

		return true;
	}
}
