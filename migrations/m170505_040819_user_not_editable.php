<?php

use yii\db\Migration;

class m170505_040819_user_not_editable extends Migration
{
    public $tableName = '{{%user}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'not_editable', 'SMALLINT DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'not_editable');

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
