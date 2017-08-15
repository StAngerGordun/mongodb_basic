<?php
/**
 * Created by PhpStorm.
 * User: ANDREW
 * Date: 15.08.2017
 * Time: 13:38
 */

namespace app\models;


use yii\mongodb\ActiveRecord;

class Gender extends ActiveRecord
{
    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'gender';
    }
    
    /**
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return
            [
                '_id',
                'name',
            ];
    }
}