<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\AuthItem;
use backend\modules\base\models\Entity\Notify;
use backend\modules\base\models\Entity\User;
use backend\modules\helpers\user\UserHelpers;
use mysql_xdevapi\Exception;
use Yii;
use yii\base\Model;

/**
 * Подтверждение регистрации
 * Class SignupConfirm
 * @package backend\modules\base\models
 * @property $invited_id
 * @property $status
 * @property $auth_item
 */
class SignupConfirm extends Model
{
    public $invited_id;
    public $status;
    public $auth_item;

    public function rules()
    {

        return [
            [['invited_id','status'], 'required'],
            ['invited_id', 'integer'],
            ['auth_item', 'default'],
            ['status', 'boolean'],
        ];
    }

    public function confirmUserRegistr()
    {
        if (!$this->validate()) return null;

        if (\Yii::$app->user->can('confirmUser', ['invited_id' => $this->invited_id])) {
            $transaction = \Yii::$app->getDb()->beginTransaction();
            $return_mes = '';
            try {
                if ($this->status) {
                    //удаляем текущее уведомление с подтверждением решистрации
                    $notify = Notify::GetNotifyByViewAndUSerId($this->invited_id, 'auth');
                    foreach ($notify as $item) {
                        $params = json_decode($item->params, true);
                        if ($params['invited'] == $this->invited_id) {
                            $item->delete();
                            break;
                        }
                    }
                    //генерация пароля и отправка письма
                    $invited = User::findIdentity($this->invited_id);
                    $password = UserHelpers::GenPassword(8);
                    $invited->setPassword($password);
                    if ($invited->save()) {
                        //отправка письма с подтверждением регистрации пользователя
                        Yii::$app->mailer->compose('@backend/modules/base/views/user/signup_confirm', [
                            'password' => $password,
                        ])
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setTo($invited->email)
                            ->setSubject('ПИЭ Диск' . ': Подтверждение регистрации ')
                            ->send();
                    }

                    //добавление роли пользователю
                    $auth = Yii::$app->authManager;
                    $authorRole = $auth->getRole($this->auth_item);
                    $auth->assign($authorRole, $invited->id);

                    $return_mes = 'Подтверждение регистрации выполнено успешно';
                } else {
                    //в регистрации отказано
                    $invited = $this->findModel($this->user_id);
                    Yii::$app->mailer->compose('@backend/modules/base/views/user/signup_denial.php')
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($invited->email)
                        ->setSubject('ПИЭ Диск' . ': Подтверждение регистрации ')
                        ->send();
                    if (!$invited->delete()) throw new Exception('Не удалось выполнить операцию.');

                    $return_mes = 'Пользователю отказано в регистрации';
                }
            }catch (\Exception $e){
                $transaction->rollBack();
                return 'Произошла ошибка';
            }
            $transaction->commit();
            return $return_mes;
        }
    }
}
