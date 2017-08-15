<?php

class m170815_101956_create_addresses_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('addresses');
        $this->createIndex('addresses', 'user_id');
    }

    public function down()
    {
        $this->dropIndex('addresses', 'user_id');
        $this->dropCollection('addresses');
    }
}
