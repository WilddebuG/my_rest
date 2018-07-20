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
        $data = \Yii::$app->getRequest()->getBodyParams();
        $datetime = new \DateTime("now");

        if (empty($data)) {
            ApiHelper::sendRequest(400, ['status' => 0, 'error_code' => 400, 'errors' => "bad param request"]);
        }

        $user = User::find()->thisUser()->isActive()->one();
        $userProfile = UserProfile::find()->thisUser()->one();

        if (!$user) {
            ApiHelper::sendRequest(400, ['status' => 0, 'error_code' => 400, 'errors' => "User not exist"]);
        }

        if ($user->load($data, '') && $userProfile->load($data, '')) {
            $user->updated_at = $datetime->getTimestamp();
            $user->created_at = $user->getOldAttribute('created_at');
            $isValid = $user->validate();
            $isValid = $userProfile->validate() && $isValid;
            if ($isValid) {
                $user->save(false);
                $userProfile->save(false);
                ApiHelper::sendRequest(200, ['status' => 1, 'data' => [$user->toArray(), $userProfile->toArray()]]);
            }
        }
        return $user;
    }

}