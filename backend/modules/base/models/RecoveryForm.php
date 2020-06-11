<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\User;
use backend\modules\helpers\user\UserHelpers;
use Yii;
use yii\base\Model;

/**
 * Class RecoveryForm
 * @package backend\modules\base\models
 */
class RecoveryForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
        ];
    }

    //оюновление пароля с отправкой на почту
    public function recovery()
    {
        if (!$this->validate()) return 'Произошла ошибка';

        $user = User::findByEmail($this->email);
        if (empty($user)) return 'Неверный E-mail адрес';
        //генерация пароля и отправка письма
        $password = UserHelpers::GenPassword(8);
        $user->setPassword($password);
        if ($user->save()) {
            Yii::$app->mailer->compose('@backend/modules/base/views/user/signup_confirm.php', [
                'password' => $password,
            ])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($user->email)
                ->setSubject('ПИЭ Диск' . ': Востановление пароля ')
                ->send();
        }
        return 'Сообщение c новым паролем отправлено на Ваш почтовый ящик';
    }
}
