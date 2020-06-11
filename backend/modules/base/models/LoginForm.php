<?php
namespace backend\modules\base\models;

use backend\modules\base\models\Entity\User;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package backend\modules\base\models
 */
class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Проверка пароля на валидность
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Некорректный E-mail или пароль');
            }
        }
    }

    /**
     * Логирует пользователя в сис по логину(email) и паролю если он не в ч/с
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if($user->lock)return false;//если в черном списке
            return Yii::$app->user->login($user,  60 * 60);
        }
        
        return false;
    }

    /**
     * Поиск пользователя по [[email]]
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }
}
