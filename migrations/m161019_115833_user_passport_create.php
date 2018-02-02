<?php

use yii\db\Migration;
use yii\db\Schema;

class m161019_115833_user_passport_create extends Migration
{

    public $tableName = '{{%user_passport}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'serial_nr' => Schema::TYPE_STRING,
            'issued_by' => Schema::TYPE_STRING,
            'issued_date' => Schema::TYPE_INTEGER,
            'division_code' => Schema::TYPE_STRING,
            'place_of_birth' => Schema::TYPE_STRING,
            'place_of_residence' => Schema::TYPE_STRING,
        ]);
        $this->addForeignKey('user_passport_user_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addCommentOnColumn($this->tableName, 'serial_nr', 'Серия и номер паспорта');
        $this->addCommentOnColumn($this->tableName, 'issued_by', 'Кем выдан');
        $this->addCommentOnColumn($this->tableName, 'issued_date', 'Дата выдачи');
        $this->addCommentOnColumn($this->tableName, 'division_code', 'Код подразделения');
        $this->addCommentOnColumn($this->tableName, 'place_of_birth', 'Место рождения');
        $this->addCommentOnColumn($this->tableName, 'place_of_residence', 'Адрес прописки');
    }

    public function down()
    {
        $this->dropForeignKey('user_passport_user_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}
