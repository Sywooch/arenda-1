<?php

use yii\db\Migration;

class m161209_212105_side_help_add extends Migration
{
	public $tableName = '{{%side_help}}';

	public function up()
	{
		$this->createTable($this->tableName, [
			'id'      => $this->primaryKey()->comment('id'),
			'content' => $this->text()->comment('Содержание'),
			'url'     => $this->text()->comment('Ссылка'),
			'status'  => $this->smallInteger()->comment('Статус'),
		]);
	}

	public function down()
	{
		$this->dropTable($this->tableName);
	}
}
