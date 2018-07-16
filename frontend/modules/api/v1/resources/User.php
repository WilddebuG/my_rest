<?php

namespace frontend\modules\api\v1\resources;
use common\models\CardDesign;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserController extends \common\models\User
{
    public function fields()
    {
        return [
            'id',
            'email',
        ];
    }

    public function extraFields()
    {
        return ['userProfile'];
    }
}
