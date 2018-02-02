<?php

use yii\db\Migration;

class m170410_194822_alter_payment_methods extends Migration
{
	public $tableName = '{{%payment_methods}}';

    public function safeUp()
    {
	    $this->addColumn($this->tableName, 'link_id', 'VARCHAR(64) NULL');
	    $this->createIndex('idx_link_id', $this->tableName, 'link_id');
    }

    public function safeDown()
    {
	    $this->dropColumn($this->tableName, 'link_id');

	    return true;
    }
}
