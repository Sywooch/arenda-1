<?php

use yii\db\Migration;

class m170120_085201_adboard extends Migration
{
	public $tableName = '{{%ad_board}}';
	
    public function up()
    {
		$this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id'),
            'code' => $this->string(100)->comment('Code'),
            'name' => $this->string(100)->comment('Name'),
            'prices' => 'JSON',
            'description' => $this->text()->comment('Description'),
            'header_template' => $this->text()->comment('Header'),
            'item_template' => $this->text()->comment('Item'),
            'footer_template' => $this->text()->comment('Footer'),
            'enabled' => $this->smallInteger()->comment('Enabled'),
            'ads_count' => $this->integer()->comment('Ads Count'),
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
