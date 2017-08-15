<?php
/**
 * Created by PhpStorm.
 * User: ANDREW
 * Date: 15.08.2017
 * Time: 13:37
 */

namespace app\models;


use yii\mongodb\ActiveRecord;

class Addresses extends ActiveRecord
{
    
    
    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'addresses';
    }
    
    /**
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return ['_id',
            'user_id',
            'country',
            'country_short',
            'city',
            'street',
            'street_number',
            'postal_code',
            'office_number',
        ];
    }
    
    public function rules()
    {
        return [[
            [
                'user_id',
                'country',
                'country_short',
                'city',
                'street',
                'street_number',
                'postal_code',
            ]
            , 'required', 'message' => '{attribute} is required'],
            [
                ['country',
                    'country_short',
                    'city',
                    'street',
                    'street_number',
                    'postal_code',
                ], 'string', 'max' => 255],
        ];
    }
}