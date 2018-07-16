<?php
/**
 * Created by PhpStorm.
 * User: wilddebug
 * Date: 16.07.18
 * Time: 16:22
 */

namespace frontend\modules\api\v1\controllers;

use common\models\User;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use Yii;
use frontend\modules\api\v1\helpers\ApiHelper;
use yii\web\Response;

class ApiActiveController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;


        $behaviors['authenticator'] = [
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

    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if(isset($result['data']) && is_array($result['data'])) {
            $result['status'] = 1;
            ApiHelper::sendRequest(200, $result);
        } else {
            ApiHelper::sendRequest(200, ['status' => 1, 'data' => $result]);
        }
    }

    /**
     * add _meta and _links to response
     */
    public function setDataPaginator(){
        if (Yii::$app->request->getQueryParam('per-page')){
            $this->serializer = [
                'class' => 'yii\rest\Serializer',
                'collectionEnvelope' => 'data'
            ];
        }
    }

}