<?php

use yii\db\Migration;

class m161225_101438_lease_contract_foreign_key_delete extends Migration
{
	public $tableName = '{{%lease_contracts}}';

    public function up()
    {
	    $this->dropForeignKey('lease_contracts_payment_methods_fk', $this->tableName);
    }

    public function down()
    {
	    $this->addForeignKey('lease_contracts_payment_methods_fk', $this->tableName, 'payment_method_id', '{{%payment_methods}}', 'id', 'CASCADE', 'CASCADE');

        return true;
    }
}
