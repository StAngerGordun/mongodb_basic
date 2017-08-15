<?php

class m170814_155821_create_user_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('customer');
        $this->createIndex('customer', 'gender_id');
    }

    public function down()
    {
        $this->dropCollection('customer');
    }
}
