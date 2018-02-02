<?php

use yii\db\Migration;

class m170410_081208_alter_lease_contract_date_disable extends Migration
{
    public $tableName = '{{%lease_contracts}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'date_disable', 'INTEGER NULL');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'date_disable');

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
