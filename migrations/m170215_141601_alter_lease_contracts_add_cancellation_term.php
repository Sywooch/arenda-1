<?php

use yii\db\Migration;

class m170215_141601_alter_lease_contracts_add_cancellation_term extends Migration
{
    public function up()
    {
        $this->addColumn('ar_lease_contracts', 'cancellation_term', 'INTEGER NOT NULL DEFAULT 30');
    }

    public function down()
    {
       $this->dropColumn('ar_lease_contracts', 'cancellation_term');
    }
}
