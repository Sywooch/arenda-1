<?php

use yii\db\Migration;
use yii\db\Schema;

class m161010_204531_applications_roommates_create extends Migration
{

    public $tableName = '{{%applications_roommates}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'application_id' => Schema::TYPE_INTEGER,
            'first_name' => Schema::TYPE_STRING,
            'last_name' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
        ]);
        $this->addForeignKey('applications_roommates_applications_fk', $this->tableName, 'application_id', '{{%applications}}', 'id', 'CASCADE', 'CASCADE');
        $this->addCommentOnColumn($this->tableName, 'first_name', 'Имя');
        $this->addCommentOnColumn($this->tableName, 'last_name', 'Фамилия');
        $this->addCommentOnColumn($this->tableName, 'email', 'Email');
    }

    public function down()
    {
        $this->dropForeignKey('applications_roommates_applications_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}
