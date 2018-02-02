<?php

use yii\db\Migration;

class m161129_140442_external_platform_feeds_create extends Migration
{

    public $tableName = '{{%external_platform_feeds}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'platform_id' => $this->integer(),
            'ad_id' => $this->integer(),
            'body' => $this->text(),
            'params' => 'json',
            'status' => $this->integer()->defaultValue(0),
        ]);

        $this->addCommentOnColumn($this->tableName, 'id', 'id');
        $this->addCommentOnColumn($this->tableName, 'platform_id', 'Идентификатор платформы');
        $this->addCommentOnColumn($this->tableName, 'ad_id', 'Идентификатор объявления');
        $this->addCommentOnColumn($this->tableName, 'body', 'Тело фида');
        $this->addCommentOnColumn($this->tableName, 'params', 'Параметры');
        $this->addCommentOnColumn($this->tableName, 'status', 'Статус');

        $this->addForeignKey('ext_platform_feed_to_platform_fk', $this->tableName, 'platform_id', '{{%external_platforms}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('ext_platform_feed_to_ads_fk', $this->tableName, 'ad_id', '{{%ads}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('ext_platform_feed_to_platform_fk', $this->tableName);
        $this->dropForeignKey('ext_platform_feed_to_ads_fk', $this->tableName);
        $this->dropTable($this->tableName);
    }

}
