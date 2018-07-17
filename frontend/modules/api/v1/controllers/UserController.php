<?php
/**
 * Created by PhpStorm.
 * User: wildDebug
 * Date: 16.07.18
 * Time: 14:45
 */

namespace frontend\modules\api\v1\controllers;


use frontend\modules\api\v1\resources\User as UserResource;
use frontend\modules\api\v1\helpers\ApiHelper;
use frontend\modules\api\v1\resources\User;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;


class UserController extends ApiActiveController
{

    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\User';

    public function actions()
    {
        $actions = parent::actions();
        $actions = ArrayHelper::merge($actions, [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'actionIndex']
            ],
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
//                'prepareDataProvider' => [$this, 'actionUpdate']
            ],
        ]);

        unset($actions['create'], $actions['update'], $actions['options']);
        return $actions;
    }

    public function actionIndex()
    {
        $query = UserResource::find()->with('userProfile');
        return new ActiveDataProvider(array(
            'query' => $query
        ));
    }

    public function actionUpdate($id)
    {
        /* @var $model UserResource */
        $data = \Yii::$app->getRequest()->getBodyParams();

        if (empty($data['email']) || empty($data['id'])) {
            ApiHelper::sendRequest(400, ['status' => 0, 'error_code' => 400, 'errors' => "bad param request"]);
        }
        $userExist = User::find()->andWhere(['id' => $data['id'], 'email' => $data['email']])->one();
        if (!$userExist){
            ApiHelper::sendRequest(400, ['status' => 0, 'error_code' => 400, 'errors' => "User not exist"]);
        }
        $model = new UserForm();

        return $userExist;
    }

}