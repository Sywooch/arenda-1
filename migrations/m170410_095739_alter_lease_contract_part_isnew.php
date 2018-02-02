<?php

use yii\db\Migration;

class m170410_095739_alter_lease_contract_part_isnew extends Migration
{
    public $tableName = '{{%lease_contract_participants}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'is_new', 'SMALLINT DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'is_new');

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
