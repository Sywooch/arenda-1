<?php

use yii\db\Migration;

class m161224_122458_real_estate_dom extends Migration
{
	public $tableName = '{{%real_estate}}';

	public function up()
	{
		$this->addColumn($this->tableName, 'dom', 'INTEGER');
	}

	public function down()
	{
		$this->dropColumn($this->tableName, 'dom');

		return true;
	}
}
