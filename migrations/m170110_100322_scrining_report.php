<?php

use yii\db\Migration;

class m170110_100322_scrining_report extends Migration
{
	public $tableName = '{{%screening_report}}';
	
    public function up()
    {
		$this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id'),
            'user_id' => $this->integer()->comment('Creator'),
            'type' => $this->smallInteger()->comment('Type'),
            'name_first' => $this->string(100)->comment('First Name'),
            'name_last' => $this->string(100)->comment('Last Name'),
            'name_middle' => $this->string(100)->comment('Middle Name'),
            'birthday' => $this->date()->comment('Birth day'),
            'phone' => $this->string(100)->comment('Phone number'),
            'address' => $this->string(250)->comment('Registration Address'),
            'post_code' => $this->string(10)->comment('Postal code'),
            'insurance' => $this->string(50)->comment('Insurance number'),
            'document' => $this->string(250)->comment('Document'),
            'comment' => $this->text()->comment('Admin comment'),
            'status' => $this->smallInteger()->comment('Status'),
            'report_date' => $this->integer()->comment('Date'),
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
