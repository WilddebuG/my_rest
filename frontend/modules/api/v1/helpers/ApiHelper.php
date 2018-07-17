<?php
/**
 * Created by PhpStorm.
 * User: nickbatjar
 * Date: 6/13/16
 * Time: 13:29
 */

namespace frontend\modules\api\v1\helpers;

use yii;
use common\models\User;
//use common\models\UserProfile;

class ApiHelper
{

    public static function setHeader($status)
    {
        Yii::$app->response->statusCode = $status;

        $status_header = 'HTTP/1.1 ' . $status . ' ' . self::_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Devabit <devabit.com>");
    }
    public static function _getStatusCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public static function sendRequest($code, $data = array()){
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;

        $_status = self::getIsUserActive(Yii::$app->user->id);

        if ((is_array($_status) && $_status['status'] == User::STATUS_ACTIVE) or Yii::$app->user->id == null) {
            self::setHeader($code);
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            self::setHeader(401);
            echo json_encode(['status' => 0, 'error_code' => 401, 'errors' => 'Unauthorized'], JSON_PRETTY_PRINT);
        }
        Yii::$app->end();
    }

    /**
     * @return array|null
     */
    public static function getUserData($userId){
        if($userId){
            $tblUser = User::tableName();
//            $tblProfil = UserProfile::tableName();
            $model = User::find()
                ->select([
                    $tblUser.'.id',
                    $tblUser.'.email',
                    $tblUser.'.access_token',
                    $tblUser.'.created_at',
                    $tblUser.'.updated_at',
                    $tblUser.'.status'
                ])
//                ->joinWith('userProfile')
//                ->andWhere([
//                    'status' => User::STATUS_ACTIVE,
//                    'id' => $userId
//                ])
                ->one();

            if($model){
                $uArr = array_filter($model->attributes);

//                $uArr['password'] = $model->password_hash;
                unset($uArr['password_hash']);
//                $uArr['firstname'] = $model->userProfile->firstname;
//                $uArr['lastname'] = $model->userProfile->lastname;
//                $uArr['cardnumber'] = $model->userProfile->cardnumber;
//                $uArr['phone'] = $model->userProfile->phone;
//                $uArr['companyId'] = $model->userProfile->companyId;
//                $uArr['city_id'] = $model->userProfile->city_id;
//                $uArr['image'] = $model->userProfile->getAvatar() ? \Yii::$app->getRequest()->getHostInfo() . $model->userProfile->getAvatar() : '';


//                $cImg = \common\models\CardDesign::getCardData(['cardnumber' => $model->userProfile->cardnumber]);
//                $uArr['cardImage'] = !empty($cImg) ? \Yii::$app->getRequest()->getHostInfo() . $cImg : '';


                return $uArr;
            }

        }

        return null;
    }


    public static function getIsUserActive($userId){
        if($userId){
            $tblUser = User::tableName();
            $model = User::find()
                ->select([
                    $tblUser.'.id',
                    $tblUser.'.status'
                ])
                ->andWhere([
                    'id' => $userId
                ])
                ->one();

            if($model){
                $uArr = array_filter($model->attributes);

               return $uArr;
            }

        }

        return null;
    }

}