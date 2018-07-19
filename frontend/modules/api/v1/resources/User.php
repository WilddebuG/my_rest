<?php

namespace frontend\modules\api\v1\resources;

use common\models\UserProfile;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class User extends \common\models\User
{
    public $password;
//    public $userProfile;

    public function fields()
    {
        return [
            'id',
            'email',
            'firstName' => function ($model) {
                return $model->userProfile->firstname;
            },
            'lastName' => function ($model) {
                return $model->userProfile->lastname;
            },
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];
    }
}
