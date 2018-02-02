<?php

use yii\db\Migration;

class m170110_082903_scrining_request extends Migration
{
	public $tableName = '{{%screening_request}}';
	
    public function up()
    {
		$this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id'),
            'user_id' => $this->integer()->comment('Creator'),
            'type' => $this->smallInteger()->comment('Type'),
            'name_first' => $this->string(100)->comment('First Name'),
            'name_last' => $this->string(100)->comment('Last Name'),
            'email' => $this->string(100)->comment('Email'),
            'reporter_id' => $this->integer()->comment('Reporter ID'),
            'report_credit_id' => $this->integer()->comment('Credit History Report ID'),
            'report_bio_id' => $this->integer()->comment('Bio Report ID'),
            'request_date' => $this->integer()->comment('Date'),
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
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
