<?php

namespace app\controllers;

use app\models\Customer;
use app\models\Gender;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserForm;
use app\models\Addresses;

//use app\models\Customer;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $users = Customer::getCollection()->aggregate([
            ['$lookup' =>
                 [
                     'from'         => "addresses",
                     'localField'   => "_id",
                     'foreignField' => "user_id",
                     'as'           => "addresses",
                 ],
            ],
            ['$lookup' =>
                 [
                     'from'         => "gender",
                     'localField'   => "gender_id",
                     'foreignField' => "_id",
                     'as'           => "gender",
                 ],
            ]]);
        //var_dump($users);die();
        return $this->render('index', ['users' => $users]);
    }
    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    
    public function actionCustomer()
    {
        
        $model = new UserForm();
        //var_dump(Gender::find()->select(['_id'])->where(["name" => "man"])->one()['_id']);die();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $customerData = Yii::$app->request->post()['UserForm'];
            //var_dump($customerData); die();
            $user = new Customer();
            $user->name = $customerData['name'];
            $user->surname = $customerData['surname'];
            $user->login = $customerData['login'];
            $user->password = $customerData['password'];
            $user->created_at = date("H:i:s d-m-Y");
            $user->gender_id = $customerData['gender'] == 1 ? Gender::find()->select(['_id'])->where(["name" => "man"])->one()['_id'] :
                Gender::find()->select(['_id'])->where(["name" => "woman"])->one()['_id'];
            $user->save();
            
            
            $count = count($customerData['country']);
            for ($i = 0; $i < $count; $i++)
            {
                $addresses = new Addresses();
                $addresses->user_id = $user->_id;
                $addresses->country = $customerData['country'][$i];
                $addresses->country_short = $customerData['country_short'][$i];
                $addresses->city = $customerData['locality'][$i];
                $addresses->street = $customerData['street'][$i];
                $addresses->street_number = $customerData['street_number'][$i];
                $addresses->postal_code = $customerData['postal_code'][$i];
                $addresses->office_number = $customerData['office_number'][$i];
                $addresses->save();
            }
            
            return $this->redirect('index.php');
        }
        else
            return $this->render('customer', ['model' => $model]);
    }
}
