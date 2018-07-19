<?php
/**
 * Created by PhpStorm.
 * User: wildDebug
 * Date: 16.07.18
 * Time: 14:45
 */

namespace frontend\modules\api\v1\controllers;


use common\models\UserProfile;
use frontend\modules\api\v1\resources\User as UserResource;
use frontend\modules\api\v1\helpers\ApiHelper;
use common\models\User;
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
        $query = UserResource::find();
        return new ActiveDataProvider(array(
            'query' => $query
        ));
    }

    public function actionUpdate()
    {
        /* @var $model UserResource */
        $data = \Yii::$app->getRequest()->getBodyParams();

        if (empty($data['email']) || empty($data['id'])) {
            ApiHelper::sendRequest(400, ['status' => 0, 'error_code' => 400, 'errors' => "bad param request"]);
        }
        $user = UserResource::find()->andWhere(['id' => $data['id'], 'email' => $data['email']])->one();
        $userProfile = UserProfile::find()->andWhere(['user_id' => $data['id']])->one();

        if (!$user) {
            ApiHelper::sendRequest(400, ['status' => 0, 'error_code' => 400, 'errors' => "User not exist"]);
        }

        if ($user->load($data, '') && $userProfile->load($data,'')) {
            var_dump($user);exit;
            $isValid = $user->validate();
            $isValid = $userProfile->validate() && $isValid;
            if ($isValid) {
                $user->save(false);
                $userProfile->save(false);
                ApiHelper::sendRequest(200, ['status' => 1, 'data' => $userProfile]);
            }
        }
        return $user;
    }

}