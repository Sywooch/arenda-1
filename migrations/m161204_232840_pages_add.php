<?php

use yii\db\Migration;

class m161204_232840_pages_add extends Migration
{

    public $tableName = '{{%pages}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id'),
            'image' => $this->string(50)->comment('Картинка'),
            'title' => $this->string(250)->comment('Загаловок'),
            'content' => $this->text()->comment('Содержание'),
            'url' => $this->text()->comment('Ссылка'),
            'status' => $this->smallInteger()->comment('Статус'),
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }

}
