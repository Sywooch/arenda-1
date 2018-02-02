<?php

use yii\db\Migration;

class m170328_113431_alter_scriningreports extends Migration
{
    public $tableName = '{{%screening_report}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'request_id', 'CHARACTER VARYING(32)');
        $this->addColumn($this->tableName, 'result', 'json');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'request_id');
        $this->dropColumn($this->tableName, 'result');

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
