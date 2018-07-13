<?php
/**
 * Created by PhpStorm.
 * User: wilddebug
 * Date: 13.07.18
 * Time: 17:27
 */

namespace frontend\modules\api\v1\controllers;


use frontend\modules\api\v1\models\forms\LoginForm;
use yii\rest\Controller;
use yii\web\Response;
use Yii;

class LoginController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm();
        $data = Yii::$app->request->bodyParams;
        $model->username = $data['username'];
        $model->password = $data['password'];

        if ($model->auth()) {

            $this->setLoginAttempts(0); //if login is successful, reset the attempts
            return $model;
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