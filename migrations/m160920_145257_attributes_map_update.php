<?php

use yii\db\Migration;
use yii\db\Schema;

class m160920_145257_attributes_map_update extends Migration
{
    public $tableName = '{{%attributes_map}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'label_for_customers', Schema::TYPE_TEXT);
        $this->addColumn($this->tableName, 'show_to_customers', Schema::TYPE_SMALLINT . ' DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'show_to_customers');
        $this->dropColumn($this->tableName, 'label_for_customers');
    }

}