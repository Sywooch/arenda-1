<?php

use yii\db\Migration;

class m170423_061556_is_scorista_wait extends Migration
{
    public $tableNamePassport = '{{%user_passport}}';
    public $tableNameScriningReport = '{{%screening_report}}';

    public function up()
    {
        $this->addColumn($this->tableNamePassport, 'is_scorista_wait', 'INTEGER NULL DEFAULT 0');
        $this->addColumn($this->tableNameScriningReport, 'is_scorista_wait', 'INTEGER NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn($this->tableNamePassport, 'is_scorista_wait');
        $this->dropColumn($this->tableNameScriningReport, 'is_scorista_wait');
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
