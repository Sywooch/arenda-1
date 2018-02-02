<?php

use yii\db\Migration;
use yii\db\Schema;

class m160930_092645_applications_create extends Migration
{

    public $tableName = '{{%applications}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'ad_id' => Schema::TYPE_INTEGER,
            'data' => 'json',
            'date_created' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_SMALLINT . ' DEFAULT 1',
        ]);

        $this->addForeignKey('applications_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('applications_ads_fk', $this->tableName, 'ad_id', '{{%ads}}', 'id', 'CASCADE', 'CASCADE');
        $this->addCommentOnColumn($this->tableName, 'user_id', 'Пользователь');
        $this->addCommentOnColumn($this->tableName, 'ad_id', 'объявление');
        $this->addCommentOnColumn($this->tableName, 'data', 'Доп. Данные');
        $this->addCommentOnColumn($this->tableName, 'date_created', 'Создано');
        $this->addCommentOnColumn($this->tableName, 'status', 'Статус');
    }

    public function down()
    {
        $this->dropForeignKey('applications_user_fk', $this->tableName);
        $this->dropForeignKey('applications_ads_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}
