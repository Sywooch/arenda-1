<?php

use yii\db\Migration;

class m161214_122813_real_estate_new_fields extends Migration
{
	public $tableName = '{{%real_estate}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'title', 'VARCHAR(255) NULL');
        $this->addColumn($this->tableName, 'address', 'VARCHAR(255) NULL');
        $this->addColumn($this->tableName, 'building', 'INTEGER');
    }

    public function down()
    {
	    $this->dropColumn($this->tableName, 'title');
	    $this->dropColumn($this->tableName, 'address');
	    $this->dropColumn($this->tableName, 'building');

        return true;
    }
}
