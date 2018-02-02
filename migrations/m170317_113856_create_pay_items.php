<?php

use yii\db\Migration;

class m170317_113856_create_pay_items extends Migration
{
    public $tableName = '{{%pay_ad_items}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'payId' => $this->integer()->comment('Оплаты'),
            'adId' => $this->integer()->comment('Объявление'),
            'serviceId' => $this->integer()->comment('Сервис'),
            'statusId'=>$this->smallInteger()->comment('Статус'),
            'dateCreate'=>$this->timestamp()->comment('Дата создания'),
            'dateProcess'=>$this->dateTime()->comment('Дата обработки'),
            'sum'=>$this->float()->comment('Сумма'),
        ]);

        $this->createIndex('idx-payId',$this->tableName,'payId');
        $this->addForeignKey('fk-items-pay',$this->tableName,'payId','{{%pay}}','id');
    }

    public function down()
    {
        $this->dropForeignKey('fk-items-pay',$this->tableName);
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
