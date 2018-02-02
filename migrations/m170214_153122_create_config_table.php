<?php

use yii\db\Migration;

/**
 * Handles the creation of table `config`.
 */
class m170214_153122_create_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ar_config', [
            'id' => $this->primaryKey(),
            'agreement_fixed_part_change_notification' => $this->integer()->notNull()->defaultValue(30),
            'agreement_days_to_transfer_object' => $this->integer()->notNull()->defaultValue(30),
            'agreement_days_to_prolongation' => $this->integer()->notNull()->defaultValue(30),
        ]);
        
        $this->insert('ar_config', ['id' => 1]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ar_config');
    }
}
