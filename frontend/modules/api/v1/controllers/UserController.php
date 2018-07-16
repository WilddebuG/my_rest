<?php
/**
 * Created by PhpStorm.
 * User: wilddebug
 * Date: 16.07.18
 * Time: 14:45
 */

namespace frontend\modules\api\v1\controllers;


use frontend\modules\api\v1\resources\User;
use yii\web\Response;
use frontend\modules\api\v1\helpers\ApiHelper;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;


class UserController extends ApiActiveController
{

    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        $behaviors['authenticator'] = [
            'except' => ['index','view'],
            'class' => CompositeAuth::className(),
            'authMethods' => [
                [
                    'class' => HttpBasicAuth::className(),
                    'auth' => function ($username, $password) {
                        $user = User::findByLogin($username);
                        return $user->validatePassword($password)
                            ? $user
                            : null;
                    }
                ],
                HttpBearerAuth::className(),
                QueryParamAuth::className()
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions = ArrayHelper::merge($actions, [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'actionIndex']
            ],
        ]);

        unset($actions['create'],$actions['options']);
        return $actions;
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if(isset($result['data']) && !empty($result['data'])) {
            $result['status'] = 1;
            ApiHelper::sendRequest(200, $result);
        } else {
            ApiHelper::sendRequest(200, ['status' => 1, 'data' => $result]);
        }
    }

    public function actionIndex()
    {
        $query = User::find()->with('userProfile');
        return new ActiveDataProvider(array(
            'query' => $query
        ));
    }



}