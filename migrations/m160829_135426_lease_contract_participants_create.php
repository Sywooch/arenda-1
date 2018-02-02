<?php

use yii\db\Migration;
use yii\db\Schema;

class m160829_135426_lease_contract_participants_create extends Migration
{
    public $tableName = '{{%lease_contract_participants}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'lease_contract_id' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey('lease_contract_participants_lease_contract_fk', $this->tableName, 'lease_contract_id', '{{%lease_contracts}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('lease_contract_participants_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('lease_contract_participants_user_fk', $this->tableName);
        $this->dropForeignKey('lease_contract_participants_lease_contract_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}