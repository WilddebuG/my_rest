<?php
namespace frontend\modules\api\v1\models\forms;

use \common\models\User;
use \yii\base\Model;

/**
 * Api Login Form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    private $_user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],

        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
    /**
     * @return Model|null
     */
    public function auth()
    {
        if ($this->validate()) {
            $model = new User();
            var_dump($model);exit;
            $model->id = $this->getUser()->id;
//            $model->generateToken(time() + 3600 * 24);
            return $model->save() ? $model : null;
        } else {
            return null;
        }
    }
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}