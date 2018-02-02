<?php

use yii\db\Migration;

class m170412_110140_real_state_additional_fields extends Migration
{
    public function safeUp()
    {
        $this->addColumn('ar_real_estate', 'cadastr_number', $this->string(20));
        $this->addColumn('ar_real_estate', 'registration_law_kind', $this->string(100));
        $this->addColumn('ar_real_estate', 'registration_law_number', $this->string(50));
        $this->addColumn('ar_real_estate', 'registration_law_date', $this->date());
        $this->addColumn('ar_real_estate', 'encumbrance', $this->text());
        $this->addColumn('ar_real_estate', 'seizure', $this->text());
        $this->addColumn('ar_real_estate', 'third_party_problem', $this->text());

        $this->createTable('ar_real_estate_owner', [
            'id' => $this->primaryKey(),
            'real_estate_id' => $this->integer()->notNull(),
            'fio' => $this->string(255),
        ]);

        $this->addForeignKey('ar_real_estate_owner___fk', 'ar_real_estate_owner', 'real_estate_id',
            'ar_real_estate', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        echo "m170412_110140_real_state_additional_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170412_110140_real_state_additional_fields cannot be reverted.\n";

        return false;
    }
    */
}
