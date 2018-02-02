<?php

use yii\db\Migration;

class m170404_052845_alter_passport_requestid extends Migration
{
    public $tableName = '{{%user_passport}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'request_id', 'CHARACTER VARYING(32)');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'request_id');

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
