<?php

use yii\db\Migration;

class m170427_060608_scrining_is_new extends Migration
{
    public $tableName = '{{%screening_request}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'is_new', 'SMALLINT DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'is_new');

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
