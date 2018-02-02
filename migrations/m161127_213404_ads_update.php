<?php

use yii\db\Migration;

class m161127_213404_ads_update extends Migration
{

    public $tableName = '{{%ads}}';

    public function up()
    {
        $this->addColumn($this->tableName, 'date_created', $this->integer());
        $this->addColumn($this->tableName, 'date_updated', $this->integer());
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'date_created');
        $this->dropColumn($this->tableName, 'date_updated');
    }

}
