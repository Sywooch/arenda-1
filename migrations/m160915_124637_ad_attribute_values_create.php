<?php

use yii\db\Migration;
use yii\db\Schema;

class m160915_124637_ad_attribute_values_create extends Migration
{
    public $tableName = '{{%ad_attribute_values}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'ad_id' => Schema::TYPE_INTEGER,
            'attribute_id' => Schema::TYPE_INTEGER,
            'value' => Schema::TYPE_TEXT,
        ]);

        $this->addForeignKey('ad_attribute_values_ads_fk', $this->tableName, 'ad_id', '{{%ads}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('ad_attribute_values_attributes_map_fk', $this->tableName, 'attribute_id', '{{%attributes_map}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('ad_attribute_values_ads_fk', $this->tableName);
        $this->dropForeignKey('ad_attribute_values_attributes_map_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}