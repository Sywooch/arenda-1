<?php

use yii\db\Migration;

class m170323_044720_alter_customer_info_addational extends Migration
{
    public $tableName = '{{%user_customer_info}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'addational', 'json');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'addational');

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
