<?php

use yii\db\Migration;
use yii\db\Schema;

class m160915_123528_ad_images_create extends Migration
{
    public $tableName = '{{%ad_images}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'ad_id' => Schema::TYPE_INTEGER,
            'image' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey('ad_images_ads_fk', $this->tableName, 'ad_id', '{{%ads}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('ad_images_ads_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}