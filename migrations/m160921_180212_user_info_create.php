<?php

use yii\db\Migration;
use yii\db\Schema;

class m160921_180212_user_info_create extends Migration
{
    public $tableName = '{{%user_info}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'page_link' => Schema::TYPE_TEXT,
            'contact_person' => Schema::TYPE_STRING,
            'company_name' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
            'phone' => Schema::TYPE_STRING,
            'site' => Schema::TYPE_TEXT,
            'address' => Schema::TYPE_TEXT,
            'city' => Schema::TYPE_TEXT,
            'street' => Schema::TYPE_TEXT,
            'building' => Schema::TYPE_STRING,
            'corps' => Schema::TYPE_STRING,
            'apartment' => Schema::TYPE_STRING,
            'about' => Schema::TYPE_STRING,
            'photo' => Schema::TYPE_STRING,
            'logo' => Schema::TYPE_STRING,
        ]);
        $this->addForeignKey('user_info_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addCommentOnColumn($this->tableName, 'page_link', 'Ссылка на страницу');
        $this->addCommentOnColumn($this->tableName, 'contact_person', 'Контактное лицо');
        $this->addCommentOnColumn($this->tableName, 'company_name', 'Название компании');
        $this->addCommentOnColumn($this->tableName, 'email', 'Эл. почта');
        $this->addCommentOnColumn($this->tableName, 'phone', 'Номер телефона');
        $this->addCommentOnColumn($this->tableName, 'site', 'Ссылка на сайт');
        $this->addCommentOnColumn($this->tableName, 'address', 'Адрес');
        $this->addCommentOnColumn($this->tableName, 'city', 'Город');
        $this->addCommentOnColumn($this->tableName, 'street', 'Улица');
        $this->addCommentOnColumn($this->tableName, 'building', 'Дом');
        $this->addCommentOnColumn($this->tableName, 'corps', 'Корпус');
        $this->addCommentOnColumn($this->tableName, 'apartment', 'Квартира');
        $this->addCommentOnColumn($this->tableName, 'about', 'О себе');
        $this->addCommentOnColumn($this->tableName, 'photo', 'Ваша фотография');
        $this->addCommentOnColumn($this->tableName, 'logo', 'Логотип компании');
    }

    public function down()
    {
        $this->dropForeignKey('user_info_user_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}