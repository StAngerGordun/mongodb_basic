<?php
/**
 * Created by PhpStorm.
 * User: ANDREW
 * Date: 15.08.2017
 * Time: 13:35
 */

namespace app\models;


use yii\base\Model;

class UserForm extends Model
{
    public $login;
    public $password;
    public $name;
    public $surname;
    public $gender;
    public $createdDate;
    public $geocomplete;
    
    public $postal_code;
    public $country;
    public $country_short;
    public $locality;
    public $street;
    public $street_number;
    
    public $office_number;
    
    //private static $instance = null;
    //
    //public function __construct(array $config = [])
    //{
    //    parent::__construct($config);
    //}
    
    //public static function getInstance()
    //{
    //    if (self::$instance == null)
    //        self::$instance = new UserForm();
    //    return self::$instance;
    //}
    
    public function rules()
    {
        
        return [
            [['login', 'password', 'name', 'surname',
                'gender'], 'required', 'message' => '{attribute} is required'],
            [['login'], 'string', 'min' => 4, 'max' => 255],
            [['password'], 'string', 'min' => 6, 'max' => 255],
            [['country', 'country_short',
                'locality', 'street', 'street_number', 'postal_code'], 'each', 'rule' => ['required', 'message' => '{attribute} is required']]
        ];
    }
    
}