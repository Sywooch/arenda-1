<?php

use yii\db\Migration;
use yii\db\Schema;

class m160929_161737_notifications_create extends Migration
{

    public $tableName = '{{%notifications}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'message' => Schema::TYPE_TEXT,
            'data' => 'json',
            'type' => Schema::TYPE_SMALLINT . ' DEFAULT 1',
            'status' => Schema::TYPE_SMALLINT . ' DEFAULT 1',
            'date_created' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('notifications_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addCommentOnColumn($this->tableName, 'user_id', 'Пользователь');
        $this->addCommentOnColumn($this->tableName, 'message', 'Сообщение');
        $this->addCommentOnColumn($this->tableName, 'data', 'Доп. Данные');
        $this->addCommentOnColumn($this->tableName, 'type', 'Тип');
        $this->addCommentOnColumn($this->tableName, 'status', 'Статус');
        $this->addCommentOnColumn($this->tableName, 'date_created', 'Создано');
    }

    public function down()
    {
        $this->dropForeignKey('notifications_user_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}
