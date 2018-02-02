<?php

use yii\db\Migration;
use yii\db\Schema;

class m160930_092644_user_customer_info_create extends Migration
{

    public $tableName = '{{%user_customer_info}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'photo' => Schema::TYPE_STRING,
            'about' => Schema::TYPE_TEXT,
            'date_of_birth' => Schema::TYPE_INTEGER,
            'phone' => Schema::TYPE_STRING,
            'data' => 'json',
        ]);

        $this->addForeignKey('user_customer_info_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->addCommentOnColumn($this->tableName, 'phone', 'Телефон');
        $this->addCommentOnColumn($this->tableName, 'date_of_birth', 'Дата рождения');
        $this->addCommentOnColumn($this->tableName, 'about', 'О себе');
        $this->addCommentOnColumn($this->tableName, 'photo', 'Ваше фото');
        $this->addCommentOnColumn($this->tableName, 'data', 'Доп. Данные');
        $this->addCommentOnColumn($this->tableName, 'user_id', 'Тип');
    }

    public function down()
    {
        $this->dropForeignKey('user_customer_info_user_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}
