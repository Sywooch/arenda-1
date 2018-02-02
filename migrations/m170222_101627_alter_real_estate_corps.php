<?php

use yii\db\Migration;

class m170222_101627_alter_real_estate_corps extends Migration
{
    public $tableName = '{{%real_estate}}';
    public function up()
    {
        $this->alterColumn($this->tableName,'corps','CHARACTER VARYING(50)');
    }

    public function down()
    {
        echo "m170222_101627_alter_real_estate_corps cannot be reverted.\n";

        return false;
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
