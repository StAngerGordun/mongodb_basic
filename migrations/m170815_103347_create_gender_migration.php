<?php

class m170815_103347_create_gender_migration extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('gender');
        
        $this->insert('gender', ['name' => 'man']);
        $this->insert('gender', ['name' => 'woman']);
        
    }
    
    public function down()
    {
        $this->dropCollection('gender');
    }
}
