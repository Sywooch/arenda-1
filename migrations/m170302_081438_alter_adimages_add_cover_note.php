<?php

use yii\db\Migration;

class m170302_081438_alter_adimages_add_cover_note extends Migration
{
    public $tableName = '{{%ad_images}}';
    public function up()
    {
        $this->addColumn($this->tableName, 'cover', 'INTEGER NOT NULL DEFAULT 0');
        $this->addColumn($this->tableName, 'note', 'VARCHAR(255) NULL');
    }

    public function down()
    {
        $this->dropColumn($this->tableName, 'cover');
        $this->dropColumn($this->tableName, 'note');
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
