<?php
/**
 * Created by PhpStorm.
 * User: wilddebug
 * Date: 16.07.18
 * Time: 13:53
 */

namespace frontend\modules\api\v1\controllers;


use yii\rest\ActiveController;
use frontend\modules\api\v1\helpers\ApiHelper;
use Yii;

class ApiController extends ActiveController
{
    public function beforeAction($event)
    {
        $action = $event->id;
        if (isset($this->actions[$action])) {
            $verbs = $this->actions[$action];
        } elseif (isset($this->actions['*'])) {
            $verbs = $this->actions['*'];
        } else {
            return $event->isValid;
        }
        $verb = Yii::$app->request->method;

        $allowed = array_map('strtoupper', $verbs);

        if (!in_array($verb, $allowed)) {
            $this->sendRequest(400, ['status' => 0, 'error_code' => 400, 'message' => 'Method not allowed']);
        }

        return true;
    }

    public function sendRequest($code, $data = array())
    {
        ApiHelper::sendRequest($code, $data);
    }

    /**
     * @return array|null
     */
    public function getUserData()
    {
        return ApiHelper::getUserData(Yii::$app->user->identity->id);
    }

}