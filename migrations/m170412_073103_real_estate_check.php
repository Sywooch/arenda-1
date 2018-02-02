<?php

use yii\db\Migration;
use app\models\RealEstate;

class m170412_073103_real_estate_check extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%real_estate}}', 'check_status', $this->integer()->notNull()->defaultValue(RealEstate::CHECK_STATUS_NOT_RUN));

        $this->createTable('{{%real_estate_cadastr}}', [
            'id' => $this->primaryKey(),
            'cadastr_number' => $this->string()->defaultValue(null),
            'object_type' => $this->string()->defaultValue(null),
            'object_status' => $this->string()->defaultValue(null),
            'staging_date' => $this->dateTime()->defaultValue(null),
            'floor' => $this->integer()->defaultValue(null),
            'area' => $this->float()->defaultValue(null),
            'area_units'=> $this->string()->defaultValue(null),
            'cadastr_cost' => $this->float()->defaultValue(null),
            'cost_deposit_date' => $this->dateTime()->defaultValue(null),
            'cost_approval_date' => $this->dateTime()->defaultValue(null),
            'valuation_date' => $this->dateTime()->defaultValue(null),
            'address' => $this->text()->defaultValue(null),
            'oks' => $this->text()->defaultValue(null),
            'encoded_object' => $this->text()->defaultValue(null),
            'confirm_code' => $this->text()->defaultValue(null),
            'info_update_date' => $this->dateTime()->defaultValue(null),
            'transaction_id' => $this->bigInteger()->defaultValue(null),
            'document_id' => $this->bigInteger()->defaultValue(null),
            'status' => $this->integer()->defaultValue(0),
            'error' => $this->integer()->defaultValue(0),
            'document' => $this->text()->defaultValue(null)
        ]);
    }

    public function safeDown()
    {
        $this->dropColumn('{{%real_estate}}', 'check_status');
        $this->dropTable('{{%real_estate_check}}');
    }

}
