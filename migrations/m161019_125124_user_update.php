<?php

use yii\db\Migration;
use yii\db\Schema;

class m161019_125124_user_update extends Migration
{

    public $tableName = '{{%user}}';
    public $infoTableName = '{{%user_customer_info}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'middle_name', Schema::TYPE_STRING);
        $this->addColumn($this->tableName, 'date_of_birth', Schema::TYPE_INTEGER);
        $this->addColumn($this->tableName, 'phone', Schema::TYPE_STRING);
        $this->addColumn($this->tableName, 'data', 'json');

        $this->dropColumn($this->infoTableName, 'date_of_birth');
        $this->dropColumn($this->infoTableName, 'phone');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'middle_name');
        $this->dropColumn($this->tableName, 'date_of_birth');
        $this->dropColumn($this->tableName, 'phone');
        $this->dropColumn($this->tableName, 'data');

        $this->addColumn($this->infoTableName, 'date_of_birth', Schema::TYPE_INTEGER);
        $this->addColumn($this->infoTableName, 'phone', Schema::TYPE_STRING);
    }

}
