<?php

use yii\db\Migration;
use yii\db\Schema;

class m160915_124601_attributes_map_create extends Migration {

    public $tableName = '{{%attributes_map}}';
    public $defaultAttributes = [
        '0' => ['id' => '1', 'label' => 'Отношение к домашним животным', 'hint' => '', 'input_type' => 'hiddenInput', 'purpose' => '0', 'parent' => '0', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '1',],
        '1' => ['id' => '2', 'label' => 'Неразрешено', 'hint' => '', 'input_type' => 'radio', 'purpose' => '0', 'parent' => '0', 'group_with' => '1', 'before' => '', 'after' => '', 'position' => '2',],
        '2' => ['id' => '3', 'label' => 'Разрешено', 'hint' => '', 'input_type' => 'radio', 'purpose' => '0', 'parent' => '0', 'group_with' => '1', 'before' => '', 'after' => '', 'position' => '3',],
        '3' => ['id' => '4', 'label' => 'Кошки', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '3', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '4',],
        '4' => ['id' => '5', 'label' => 'Собаки', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '3', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '5',],
        '5' => ['id' => '6', 'label' => 'Не указывать', 'hint' => '', 'input_type' => 'radio', 'purpose' => '0', 'parent' => '0', 'group_with' => '1', 'before' => '', 'after' => '', 'position' => '6',],
        '6' => ['id' => '7', 'label' => 'Какие удобства вы предлагаете?', 'hint' => '', 'input_type' => 'hiddenInput', 'purpose' => '0', 'parent' => '0', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '7',],
        '7' => ['id' => '17', 'label' => 'Телевизор', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '17',],
        '8' => ['id' => '16', 'label' => 'Вай-фай', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '16',],
        '9' => ['id' => '15', 'label' => 'Утюг', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '15',],
        '10' => ['id' => '8', 'label' => 'Мебель', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '8',],
        '11' => ['id' => '9', 'label' => 'Посудомоечная машина', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '9',],
        '12' => ['id' => '10', 'label' => 'Гардеробная', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '10',],
        '13' => ['id' => '11', 'label' => 'Бассеин', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '11',],
        '14' => ['id' => '12', 'label' => 'Джакузи', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '12',],
        '15' => ['id' => '13', 'label' => 'Доступно для инвалидов', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '13',],
        '16' => ['id' => '14', 'label' => 'Фен', 'hint' => '', 'input_type' => 'checkBox', 'purpose' => '0', 'parent' => '7', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '14',],
        '17' => ['id' => '18', 'label' => 'Другие удобства', 'hint' => 'Что еще интересного вы можете предложить?', 'input_type' => 'textArea', 'purpose' => '0', 'parent' => '0', 'group_with' => '0', 'before' => '', 'after' => '', 'position' => '18']
    ];

    public function up() {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'label' => Schema::TYPE_TEXT,
            'hint' => Schema::TYPE_TEXT,
            'input_type' => Schema::TYPE_STRING,
            'purpose' => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'parent' => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'group_with' => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'before' => Schema::TYPE_TEXT,
            'after' => Schema::TYPE_TEXT,
            'position' => 'serial',
        ]);
    }

    public function down() {
        $this->dropTable($this->tableName);
    }

}
