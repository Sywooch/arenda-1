<?php

use yii\db\Migration;

class m170317_084239_create_pay extends Migration
{
    public $tableName = '{{%pay}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'sum' => $this->float()->defaultValue(0)->comment('Сумма'),
            'dateCreate' => $this->timestamp()->comment('Дата создания'),
            'dateProcessing' => $this->dateTime()->comment('Дата обработки'),
            'statusId' => $this->smallInteger()->comment('Статус'),
            'objectId' => $this->integer()->comment('Объект оплаты'),
            'typeId' => $this->smallInteger()->comment('Тип объекта(Объявление, перевод)'),
            'ip' => $this->string(32)->comment('Ip адрес'),
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
