<?php

use yii\db\Migration;
use app\models\ExternalPlatforms;

class m161129_140428_external_platforms_create extends Migration
{

    public $tableName = '{{%external_platforms}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'service_id' => $this->string(100),
            'title' => $this->string(250),
            'feed_template' => $this->text(),
            'params' => 'json',
            'status' => $this->integer()->defaultValue(0),
        ]);

        $this->addCommentOnColumn($this->tableName, 'id', 'id');
        $this->addCommentOnColumn($this->tableName, 'service_id', 'Идентификатор сервиса');
        $this->addCommentOnColumn($this->tableName, 'title', 'Название');
        $this->addCommentOnColumn($this->tableName, 'feed_template', 'Шаблон фида');
        $this->addCommentOnColumn($this->tableName, 'params', 'Параметры');
        $this->addCommentOnColumn($this->tableName, 'status', 'Статус');


        foreach ((new ExternalPlatforms)->defaultServiceLabels as $service => $name) {
            $m = new ExternalPlatforms();
            $m->service_id = $service;
            $m->title = $name;
            $m->feed_template = $m->getDefaultTemplates($m->service_id);
            $m->save();
        }
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }

}
