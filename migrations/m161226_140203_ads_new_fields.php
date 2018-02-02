<?php

use yii\db\Migration;

class m161226_140203_ads_new_fields extends Migration
{
	public $tableName = '{{%ads}}';

	public function up()
	{
		$this->addColumn($this->tableName, 'number_of_rooms_living_area', 'SMALLINT DEFAULT 0');
		$this->addColumn($this->tableName, 'elevator_passenger', 'SMALLINT DEFAULT 0');
		$this->addColumn($this->tableName, 'elevator_service', 'SMALLINT DEFAULT 0');
		$this->addColumn($this->tableName, 'pets_condition', 'SMALLINT DEFAULT 0');
		$this->addColumn($this->tableName, 'pets_allowed_list', 'CHARACTER VARYING(255)');
		$this->addColumn($this->tableName, 'facilities', 'CHARACTER VARYING(255)');
		$this->addColumn($this->tableName, 'facilities_other', 'CHARACTER VARYING(255)');
		$this->addColumn($this->tableName, 'rent_term_undefined', 'SMALLINT DEFAULT 0');
		$this->addColumn($this->tableName, 'rent_available', 'SMALLINT DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn($this->tableName, 'number_of_rooms_living_area');
		$this->dropColumn($this->tableName, 'elevator_passenger');
		$this->dropColumn($this->tableName, 'elevator_service');
		$this->dropColumn($this->tableName, 'pets_condition');
		$this->dropColumn($this->tableName, 'pets_allowed_list');
		$this->dropColumn($this->tableName, 'facilities');
		$this->dropColumn($this->tableName, 'facilities_other');
		$this->dropColumn($this->tableName, 'rent_term_undefined');
		$this->dropColumn($this->tableName, 'rent_available');

		return true;
	}

}
