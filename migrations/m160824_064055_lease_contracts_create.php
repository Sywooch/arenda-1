<?php

use yii\db\Migration;
use yii\db\Schema;

class m160824_064055_lease_contracts_create extends Migration
{
    public $tableName = '{{%lease_contracts}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'real_estate_id' => Schema::TYPE_INTEGER,
            'price_per_month' => Schema::TYPE_DECIMAL . '(11,2) DEFAULT 0',
            'payment_date' => Schema::TYPE_SMALLINT . ' DEFAULT 1',
            'date_created' => Schema::TYPE_INTEGER,
            'date_begin' => Schema::TYPE_INTEGER,
            'date_end' => Schema::TYPE_INTEGER,
            'payment_method_id' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_SMALLINT . ' DEFAULT 1'
        ]);
        $this->addForeignKey('lease_contracts_real_estate_fk', $this->tableName, 'real_estate_id', '{{%real_estate}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('lease_contracts_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('lease_contracts_payment_methods_fk', $this->tableName, 'payment_method_id', '{{%payment_methods}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('lease_contracts_payment_methods_fk', $this->tableName);
        $this->dropForeignKey('lease_contracts_real_estate_fk', $this->tableName);
        $this->dropForeignKey('lease_contracts_user_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}