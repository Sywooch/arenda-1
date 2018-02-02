<?php

use yii\db\Migration;

class m170322_122635_alter_lease_contract_facilities extends Migration
{
    public $tableName = '{{%lease_contracts}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'facilities', 'CHARACTER VARYING(255)');
        $this->addColumn($this->tableName, 'facilities_other', 'CHARACTER VARYING(255)');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'facilities');
        $this->dropColumn($this->tableName, 'facilities_other');

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
