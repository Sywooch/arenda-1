<?php

use yii\db\Migration;
use yii\db\Schema;

class m160929_185733_user_update extends Migration
{

    public $tableName = '{{%user}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'first_name', Schema::TYPE_STRING);
        $this->addColumn($this->tableName, 'last_name', Schema::TYPE_STRING);
        $this->addColumn($this->tableName, 'real_estate_count', Schema::TYPE_INTEGER . ' DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'first_name');
        $this->dropColumn($this->tableName, 'last_name');
        $this->dropColumn($this->tableName, 'real_estate_count');
    }

}
