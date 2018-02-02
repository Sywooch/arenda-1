<?php

use yii\db\Migration;

class m170322_034853_transactions_log extends Migration
{
    public $tableName = '{{%transactions_log}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(128)->comment('Назначение платежа'),
            'size' => $this->float()->defaultValue(0)->comment('Размер платежа'),
            'date_pay' => $this->date()->comment('Дата оплаты'),
            'contract_id' => $this->integer()->comment('Договор'),
            'user_id' => $this->integer()->comment('Пользователь'),
            'type' => $this->smallInteger()->comment('Тип перевода'),
            'comment' => $this->string(255)->comment('Комментарии'),
            'status' => $this->smallInteger()->defaultValue(1)->comment('Статус'),
            'created_at' => $this->integer()->comment('Дата создания'),
            'updated_at' => $this->integer()->comment('Дата обновления'),
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
