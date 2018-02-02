<?php

use yii\db\Migration;

class m170104_080539_application_new_fields extends Migration
{
	public $tableName = '{{%applications}}';

	public function up()
	{
		$this->addColumn($this->tableName, 'comment', 'CHARACTER VARYING(255)');
		$this->addColumn($this->tableName, 'is_new', 'SMALLINT DEFAULT 1');
	}

	public function down()
	{
		$this->dropColumn($this->tableName, 'comment');
		$this->dropColumn($this->tableName, 'is_new');

		return true;
	}
}
