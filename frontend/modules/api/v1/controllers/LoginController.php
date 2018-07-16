<?php
/**
 * Created by PhpStorm.
 * User: wilddebug
 * Date: 13.07.18
 * Time: 17:27
 */

namespace frontend\modules\api\v1\controllers;

use yii\filters\VerbFilter;
use Yii;
use common\models\User;
use yii\web\Response;

class LoginController extends ApiController
{

    public $modelClass = 'frontend\modules\api\v1\resources\User';


    /**
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'logout' => ['get'],
                ],
            ]
        ];
    }

    public function actionLogin()
    {
        $data = Yii::$app->request->bodyParams;
        if (empty($data['email']) || empty($data['password'])) {
            $this->sendRequest(401, ['status' => 0, 'error_code' => 400, 'errors' => "Bad parameters request"]);
        }

        $user = User::findByLogin($data['email']);

        if (empty($user) || !$user->validatePassword($data['password'])) {
            $this->sendRequest(401, ['status' => 0, 'error_code' => 401, 'errors' => "Wrong authorization data."]);
        } else {
            Yii::$app->user->identity = Yii::$app->user->loginByAccessToken($user->access_token);
        }
        $userArr = $this->getUserData();
        $this->sendRequest(200, ['status'=>1,'data'=>$userArr] );
    }


    /**
     * @return Response
     */
    public function actionLogout()
    {
        $isLogout = Yii::$app->user->logout();
        if($isLogout) {
            $this->sendRequest(200, ['status'=>1,'message'=>'user logout'] );
        } else {
            $this->sendRequest(400, ['status'=>0,'error_code'=>400, 'errors'=>'user cannot be logged out'] );
        }
    }

    protected function getLoginAttempts()
    {
        return Yii::$app->getSession()->get($this->loginAttemptsVar, 0);
    }

    protected function setLoginAttempts($value)
    {
        Yii::$app->getSession()->set($this->loginAttemptsVar, $value);
    }


}