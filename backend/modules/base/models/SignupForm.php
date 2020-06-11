<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\Notify;
use backend\modules\base\models\Entity\Profile;
use backend\modules\base\models\Entity\User;
use backend\modules\helpers\user\UserHelpers;
use Yii;
use yii\base\Model;

/**
 * Регистрация пользователя
 * Class SignupForm
 * @package backend\modules\base\models\Auth
 * @property $email;
 * @property $last_name;
 * @property $first_name;
 * @property $middle_name;
 * @property $inviter;
 */
class SignupForm extends Model
{
    public $email;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $inviter;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['last_name',   'trim'],
            ['last_name',   'required', 'message' => 'Заполните поле фамилия'],
            ['last_name',   'match',    'pattern' => '/[а-яёa-z-]*/i'],
            ['last_name',   'string',    'length' => [3, 24]],

            ['first_name',  'trim'],
            ['first_name',  'required', 'message' => 'Заполните поле имя'],
            ['first_name',  'match',    'pattern' => '/[а-яёa-z-]*/i'],
            ['first_name',  'string',    'length' => [3, 24]],

            ['middle_name', 'trim'],
            ['middle_name', 'required', 'message' => 'Заполните поле отчество'],
            ['middle_name', 'match',    'pattern' => '/[а-яёa-z-]*/i'],
            ['middle_name', 'string',    'length' => [3, 24]],

            ['inviter',     'required', 'message' => 'Выберите личность для подверждения'],
        ];
    }

    /**
     * регистрируем пользователя в системе
     * @return bool|null
     * @throws \yii\base\Exception
     */
    public function SignUp()
    {
        if (!$this->validate()) return null;
        $transaction = \Yii::$app->getDb()->beginTransaction();
        try {
            //добавляем пользователя
            $user = new User();
            $user->email = $this->email;
            $user->setPassword(UserHelpers::GenPassword(8));
            $user->inviter_id = $this->inviter;
            $user->save();

            //добавляем профиль
            $profile                 = new Profile();
            $profile->user_id        = $user->id;
            $profile->first_name     = $this->first_name;
            $profile->last_name      = $this->last_name;
            $profile->middle_name    = $this->middle_name;
            $profile->save();

            //уведомления приглашаюшего о подтверждении регистрации приглашенного
            $params = [
                'invited' => $user->id,
            ];
            $notify = new Notify();
            $notify->view = 'auth';
            $notify->params = json_encode($params);
            $notify->user_id = $this->inviter;
            $notify->save();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
        return true;
    }
}
