<?php

use yii\db\Migration;

class m170306_092209_alter_userpassport_verify_scan extends Migration
{
    public $tableName = '{{%user_passport}}';
    public function up()
    {
        $this->addColumn($this->tableName, 'verify', 'INTEGER NOT NULL DEFAULT 0');
        $this->addColumn($this->tableName, 'scan_passport', 'VARCHAR(255) NULL');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'verify');
        $this->dropColumn($this->tableName, 'scan_passport');
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
