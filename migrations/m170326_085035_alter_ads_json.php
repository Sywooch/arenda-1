<?php

use yii\db\Migration;

class m170326_085035_alter_ads_json extends Migration
{
	public $tableName = '{{%ads}}';

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
