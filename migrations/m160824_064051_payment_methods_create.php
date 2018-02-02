<?php

use yii\db\Migration;
use yii\db\Schema;

class m160824_064051_payment_methods_create extends Migration
{
    public $tableName = '{{%payment_methods}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'data' => 'json',
            'type' => Schema::TYPE_SMALLINT . '(2) DEFAULT 1',
            'status' => Schema::TYPE_SMALLINT . '(2) DEFAULT 1',
        ]);
        $this->addForeignKey('payment_methods_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('payment_methods_user_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}