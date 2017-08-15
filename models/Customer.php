<?php
/**
 * Created by PhpStorm.
 * User: ANDREW
 * Date: 14.08.2017
 * Time: 19:17
 */

namespace app\models;
use yii\mongodb\ActiveRecord;

class Customer extends ActiveRecord
{
    public function getAddresses()
    {
        return $this->hasMany(Addresses::className(), ['user_id' => '_id']);
    }
    
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['_id' =>'gender_id']);
    }
    
    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'customer';
    }
    
    /**
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return ['_id',
            'name',
            'surname',
            'login',
            'password',
            'created_at',
            'gender_id'];
    }
    
    public function rules()
    {
        return [[
                ['name',
                'surname',
                'login',
                'password',
                'gender_id', 'created_at'], 'required', 'message' => '{attribute} is required'],
            [['name',
                'surname',
                'login',
                'password'], 'string', 'max' => 255],
            [['login'], 'string',  'min' => 4],
            [['password'], 'string',  'min' => 6],
           
        ];
    }
}