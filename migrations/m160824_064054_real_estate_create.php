<?php

use yii\db\Migration;
use yii\db\Schema;

class m160824_064054_real_estate_create extends Migration
{
    public $tableName = '{{%real_estate}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'city' => Schema::TYPE_TEXT,
            'street' => Schema::TYPE_TEXT,
            'total_area' => Schema::TYPE_INTEGER,
            'corps' => Schema::TYPE_INTEGER,
            'flat' => Schema::TYPE_INTEGER,
            'metro_id' => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'cover_image' => Schema::TYPE_STRING,
        ]);
        $this->addForeignKey('real_estate_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('real_estate_user_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}