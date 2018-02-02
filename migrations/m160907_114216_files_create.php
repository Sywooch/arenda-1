<?php

use yii\db\Migration;
use yii\db\Schema;

class m160907_114216_files_create extends Migration
{
    public $tableName = '{{%files}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_STRING,
            'scheme' => Schema::TYPE_STRING,
            'host' => Schema::TYPE_TEXT,
            'path' => Schema::TYPE_TEXT,
            'title' => Schema::TYPE_TEXT,
            'extension' => Schema::TYPE_STRING,
            'size' => Schema::TYPE_INTEGER,
            'mime' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_SMALLINT,
            'owner' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }

}