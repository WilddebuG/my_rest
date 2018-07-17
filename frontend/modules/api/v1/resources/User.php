<?php

namespace frontend\modules\api\v1\resources;

use common\models\UserProfile;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class User extends \common\models\User
{
    public $password;
    public $userProfile;

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

    /**
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function saveUser()
    {
        $newRecord = $this->isNewRecord;
        var_dump($this->userProfile);exit;

        if ($this->validate()) {
            $this->status = self::STATUS_ACTIVE;

            if ($this->password) {
                parent::setPassword($this->password);
            }
            $this->userProfile['firstname'] = $this->firstname;
            $this->userProfile['lastname'] = $this->firstname;
            if ($this->save()) {
//                $userProfile = UserProfile::find($this->id)->one();
//                $userProfile->firstname = $this->firstname;
//                $userProfile->lastname = $this->lastname;
//                return $userProfile->save() ? $this : null;
                return $this;
            } else {
                throw new Exception('Model not saved');
            }

            return $this;
        }
        return null;
    }
}
