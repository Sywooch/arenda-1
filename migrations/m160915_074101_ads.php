<?php

use yii\db\Migration;
use yii\db\pgsql\Schema;

class m160915_074101_ads extends Migration
{
    public $tableName = '{{%ads}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'real_estate_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'house_type' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'accommodation_type' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'number_of_bedrooms' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'separate_bathroom' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'combined_bathroom' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'house_floors' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'location_floor' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'building_type' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'number_of_rooms' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'number_of_rooms_total_area' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'condition' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'place_add_to' => 'json',
            'watch_statistics' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'rent_cost_per_month' => Schema::TYPE_DECIMAL . '(11,2) DEFAULT 0',
            'rent_term' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'rent_available_date' => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'rent_pledge' => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'check_credit_reports' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'check_biographical_information' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'status' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
        ]);

        $this->addForeignKey('ads_real_estate_fk', $this->tableName, 'real_estate_id', '{{%real_estate}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('ads_real_estate_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}